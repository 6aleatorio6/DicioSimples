<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um novo usuário';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userDto = [
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
        ];

        $validacao = Validator::make($userDto, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', Rules\Password::defaults()],
        ]);

        if ($validacao->fails()) {
            // Mostrar erros de validação
            $this->error('Validação falhou!');
            foreach ($validacao->errors()->all() as $erro) {
                $this->error($erro);
            }
            return 1; // Retorna código de erro
        }

        $userDto['password'] = Hash::make($userDto['password']);

        try {
            $user = User::create($userDto);
            $this->info("Usuário {$user->name} criado com sucesso.");
        } catch (\Exception $e) {
            $this->error('Erro ao criar usuário: ' . $e->getMessage());
            return 1; // Retorna código de erro
        }
    }
}
