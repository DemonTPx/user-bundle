<?php declare(strict_types=1);

namespace Demontpx\UserBundle\Command;

use Demontpx\UserBundle\Service\UserManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * @copyright 2018 Bert Hekman
 */
abstract class AbstractUserCommand extends Command
{
    protected UserManagerInterface $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        parent::__construct();
        $this->userManager = $userManager;
    }

    protected function prompt(
        InputInterface $input,
        OutputInterface $output,
        string $name,
        string $questionText,
        bool $hidden = false
    )
    {
        if ( ! $input->getArgument($name)) {
            $question = new Question($questionText);
            $question->setValidator(function ($value) use ($name) {
                if (empty($value)) {
                    throw new \RuntimeException(ucfirst($name) . ' can not be empty');
                }

                return $value;
            });
            $question->setHidden($hidden);

            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}
