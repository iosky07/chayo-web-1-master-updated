<?php

namespace App\Http\Livewire;

use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateUser extends Component
{
    public $user;
    public $userId;
    public $action;
    public $button;

    protected function getRules()
    {
        $rules = ($this->action == "updateUser") ? [
            'user.email' => 'required|email|unique:users,email,' . $this->userId
        ] : [
            'user.password' => 'required|min:8|confirmed',
            'user.password_confirmation' => 'required' // livewire need this
        ];

        return array_merge([
            'user.name' => 'required|min:3',
            'user.email' => 'required|email|unique:users,email'
        ], $rules);
    }

    public function createUser ()
    {
        $this->resetErrorBag();
        $this->validate();

//        $this->user['id'] = User::latest()->value('id') + 1;

        $password = $this->user['password'];

        if ( !empty($password) ) {
            $this->user['password'] = Hash::make($password);
        }

        User::create($this->user);

        $this->temp = User::latest('id')->first();

        $this->log = [
            'user_id' => Auth::id(),
            'access' => 'create',
            'activity' => 'create user id '.$this->temp['id'].' in User table'
        ];

        Log::create($this->log);

        $this->emit('saved');
        $this->reset('user');
    }

    public function updateUser ()
    {
        $this->resetErrorBag();
        $this->validate();

        $changed_data = [];

        $model_array = [
            'name', 'email', 'role'
        ];

        #ambil data cust sebelum update
        $model_temp = User::find($this->userId);

        User::query()
            ->where('id', $this->userId)
            ->update($this->user);

        #ambil data user setelah update
        $model_temp_1 = User::find($this->userId);

        #cari data apa saja yang diubah
        foreach ($model_array as $item) {
            if ($model_temp[$item] != $model_temp_1[$item]) {
                $changed_data[] = $item;
            }
        }

        $changed_data = implode(', ', $changed_data);

        if ($changed_data != '') {
            $this->log = [
                'user_id' => Auth::id(),
                'access' => 'update',
                'activity' => 'update user id '.$model_temp['id'].' from User table. ['.$changed_data.']'.' changed'
            ];

            Log::create($this->log);
        }

        $this->emit('saved');
    }

    public function mount ()
    {
        $this->user['role']='1';
        if (!!$this->userId) {
            $user = User::find($this->userId);

            $this->user = [
                "name" => $user->name,
                "email" => $user->email,
            ];
        }

        $this->button = create_button($this->action, "User");
    }

    public function render()
    {
        return view('livewire.create-user');
    }
}
