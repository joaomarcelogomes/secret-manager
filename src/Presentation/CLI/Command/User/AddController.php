<?php

namespace SecretManager\Presentation\CLI\Command\User;

use Minicli\Command\CommandController;
use Minicli\Input;

use SecretManager\Domain\{
  UseCase\AddUser as AddUserUseCase,
  DTO\AddUser as AddUserDTO,
  ValueObject\Username,
  ValueObject\Password
};

use SecretManager\Infra\{
  Provider\PDOSession,
  Repository\UserCommandRepository,
  Service\PasswordHashing
};

class AddController extends CommandController
{
  public function handle(): void
  {
    $input = new Input('Username: ');
    $username = $input->read();

    $input = new Input('Password: ');
    $password = $input->read();

    $addUserDTO = new AddUserDTO(
      new Username($username),
      new Password($password)
    );

    $addUserUseCase = new AddUserUseCase(
      new UserCommandRepository(PDOSession::getConnection()),
      new PasswordHashing
    );

    $addUserUseCase->act($addUserDTO);
    $this->display("User created successfully!");
  }
}
