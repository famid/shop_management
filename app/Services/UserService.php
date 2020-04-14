<?php


namespace App\Services;


use App\Models\Shop;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function userRegistration($data) {
        try {
            DB::beginTransaction();
            $createUserResponse = $this->createUser($data);
            if (!$createUserResponse['success']) {
                DB::rollBack();

                return ['success' => false, 'message' => 'something went wrong'];
            }
            $createShopResponse = $this->createShop($data['shopName'], $data['shopSize'], $createUserResponse['user']->id);
            if (!$createShopResponse['success']) {
                DB::rollBack();

                return ['success' => false, 'message' => 'something went wrong'];
            }
            DB::commit();

            return $createUserResponse['user'];
        } catch (\Exception $e) {
            DB::rollBack();

            return ['success' => false, 'message' => [$e->getMessage()]];
        }

    }

    protected function createShop($shopName, $shopSize, $userId) {
        try {
            $shop = Shop::create([
                'name' => $shopName,
                'size' => $shopSize,
                'user_id' => $userId
            ]);

            if (is_null($shop)) {
                return ['success' => false, 'message' => 'Something went wrong!'];
            }

            return ['success' => true, 'message' => 'shop has been created successfully'];
        }catch(\Exception $e) {

            return ['success' => false, 'message' => [$e->getMessage()]];
        }
    }

    protected function createUser($data) {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            if (is_null($user)) {
                return ['success' => false, 'message' => 'Something went wrong!'];
            }

            return ['success' => true , 'user' => $user];
        } catch (\Exception $e){

            return ['success' => false, 'message' => [$e->getMessage()]];
        }
    }
}
