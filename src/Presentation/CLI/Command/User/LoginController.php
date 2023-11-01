<?php

namespace SecretManager\Presentation\CLI\Command\User;

use Minicli\Command\CommandController;
use Minicli\Input;

use SecretManager\Domain\{
  UseCase\CreateSession as CreateSessionUseCase,
  DTO\CreateSession as CreateSessionDTO,
  ValueObject\Username,
  ValueObject\Password
};

use SecretManager\Infra\{
  Provider\PDOSession,
  Service\PasswordHashing
};
use SecretManager\Infra\Repository\SessionCommandRepository;
use SecretManager\Infra\Repository\UserQueryRepository;

class LoginController extends CommandController
{
  public function handle(): void
  {
    try {
      $input = new Input('Username: ');
      $username = $input->read();
  
      $input = new Input('Password: ');
      $password = $input->read();
  
      $createSessionDTO = new CreateSessionDTO(
        new Username($username),
        Password::withoutValidation($password)
      );
  
      $pdoConn = PDOSession::getConnection();
      $createSessionUseCase = new CreateSessionUseCase(
        new SessionCommandRepository($pdoConn),
        new UserQueryRepository($pdoConn),
        new PasswordHashing
      );
  
      $createSessionUseCase->act($createSessionDTO);
      $this->display("Successfully logged! Your session expires in 10 minutes");
    } catch (\Throwable $th) {
      $this->error("Invalid username or password!");
    }
  }
}
