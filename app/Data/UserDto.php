<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Email;

class UserDto extends \Spatie\LaravelData\Data
{

    public function __construct(

        public int    $id,
                      #[email]
                      public string $email,
        public string $name,
        public string $first_name,
        public string $last_name,
        public string $avatar,
        public string $password,
    )
    {
    }

}
