<?php

namespace App\Controllers;

use App\Models\User;

class UsersController extends Controller
{
    /**
     * GET
     * calculation count of email domain of users
     * return main page
     */
    public function actionIndex()
    {
        $arrayDomains = [];
        $domainsCount = [];
        $users = User::get()->toArray();
        $emails = array_column($users, 'email');
        foreach ($emails as $email) {
            $emailsExplode = explode(',', $email);
            foreach ($emailsExplode as $item) {
                $itemExplode = explode('@', $item);
                $nameDomain = empty($itemExplode[1]) ? 'without email' : $itemExplode[1];
                $arrayDomains[$nameDomain][] = $itemExplode[0];
            }
        }

        foreach ($arrayDomains as $key=> $arrayDomain){
            $domainsCount[$key] = count($arrayDomain);
        }
        $this->render('index', compact('domainsCount'));
    }

    /**
     * seeding for generate of users
     */
    public function actionSeed()
    {
        $arrayNames = ['Света', 'Маша', 'Даша', 'Ира', 'Оля', 'Катя', 'Аня', 'Наташа', 'Вика', 'Саша'];
        $arrayDomains = ['gmail.com', 'yander.ru', 'mail.ru', 'rambler.ru'];
        for ($i = 0; $i <= 20; $i++) {
            User::create([
               'name' => $arrayNames[rand(0,9)],
               'gender' => 1,
               'email' =>$this->generateStr() . '@' . $arrayDomains[rand(0,3)] .','
                   . $this->generateStr() . '@' . $arrayDomains[rand(0,3)].','
                   . $this->generateStr() . '@' . $arrayDomains[rand(0,3)]
            ]);
        }
        echo 'created 20 users';
    }

    /**
     * generate random string (length = 8)
     */
    public function generateStr(){
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $length = rand(1,8);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

}