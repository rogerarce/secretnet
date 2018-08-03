<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tree;
use App\Models\Wallet;
use App\Models\AccountType;
use App\Models\DirectReferral;
use App\Helpers\ProfitShare;
use App\Traits\ConnectedTables;
use App\Traits\Logger;

class UserSeeder extends Seeder
{
    use ConnectedTables;
    use Logger;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = collect(json_decode(file_get_contents(public_path('js/localization.json')))->Sheet1);
        foreach ($users as $user) {
            $this->createUser($user);     
        }
    }

    private function createUser($object)
    {
        $type = isset($object->account_type) ? $object->account_type : 'silver';
        $this->profitBonus($type);
        $name = explode("@", $object->email);
        $user = User::firstOrCreate([
            'email'        => $object->email,
        ],[
            'first_name'   => $name[0],
            'last_name'    => ' ',
            'password'     => \Hash::make(123456789),
            'address'      => 'Philippines',
            'user_type'    => 'customer',
            'account_type' => $this->accountTypeID($type),
            'mobile'       => '00000000000',
        ]);

        $this->createTree($user, 0);
        $this->createInitials($user);
        $this->setupPosition($object->position, $object->upline_email, $user->id, $user->email);
        $this->directReferral($object->direct_referral, $type);
    }

    private function createTree($user, $referral_id)
    {
        echo "Creating tree for " . $user->email . "\n";
        Tree::create([
            'position'           => 'left',
            'user_id'            => $user->id,
            'left_user_id'       => 0,
            'right_user_id'      => 0,
            'direct_referral_id' => $referral_id,
        ]);
    }

    private function profitBonus($account_type = 'silver')
    {
        $type = AccountType::where('type', strtolower(str_replace(" ", "",$account_type)))->first();
        $profit_share = new ProfitShare($type);
        $profit_share->start();
    }

    private function accountTypeID($account_type = 'silver')
    {
        return AccountType::where('type', strtolower(str_replace(" ", "",$account_type)))->first()->id;
    }

    private function setupPosition($position, $upline_email, $user_id, $email)
    {
        echo "Setup Position tree for " . $user_id . " $position \n";
        $user = User::firstOrCreate(['email' => $upline_email],
            [
                'first_name' => 'the secret',
                'last_name' => 'the secret',
            ]);

        $tree = Tree::where('user_id', $user->id)->first();
        if (!$tree) {
            $position = strtolower($position); 
            $tree = Tree::create([
                'position'           => $position,
                'user_id'            => $user->id,
                'left_user_id'       => $position == 'left' ? $user_id : 0,
                'right_user_id'      => $position == 'right' ? $user_id : 0,
                'direct_referral_id' => 0
            ]); 
        } else {
            $tree[$position . '_user_id'] = $user_id;
            $tree->save();
        }
    }

    private function directReferral($dr_email, $account_type)
    {
        echo 'Direct referral bonus ' . $dr_email . "\n";
        $type = AccountType::where('type', strtolower(str_replace(" ", "",$account_type)))->first();
        $email = $dr_email == 'thesecret@gmail.com' ? 'thesecret14@gmail.com' : $dr_email;
        $user = User::where('email', $email)->first();
        if ($direct_referral = $user->directReferral) {
            $direct_referral->total_earning += $type->direct_referral;
            $direct_referral->save();
        } else {
            DirectReferral::create([
                'user_id'       => $user->id,
                'total_earning' => $type->direct_referral,
            ]);
        }

        $this->profit($type->direct_referral, 'Direct Referral', $user->id);
    }
}
