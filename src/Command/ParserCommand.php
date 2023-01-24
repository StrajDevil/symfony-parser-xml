<?php

namespace App\Command;

use App\Service\Product;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:parser',
    description: 'Парсер XML файла продуктов полученных по ссылке',
)]
class ParserCommand extends Command
{
    use LockableTrait;

    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;

        parent::__construct();
    }
    protected function configure(): void
    {
        $this->addArgument('uri', InputArgument::REQUIRED, 'Путь до XML файла');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('Команда уже запущена в другом процессе.');

            return Command::FAILURE;
        }

        $io = new SymfonyStyle($input, $output);
        $uri = $input->getArgument('uri');

        $validate = $this->validate($uri);

        if ($validate['error']) {
            $io->note(sprintf($validate['message'], $uri));

            return Command::INVALID;
        }

        $this->product->get($uri);

        $io->success('Команда выполнена.');

        return Command::SUCCESS;
    }

    /**
     * Проверка аргумента
     * @param string $uri Проверяемый аргумент
     * @return array
     */
    private function validate(string $uri): array
    {
        if (!filter_var($uri, FILTER_VALIDATE_URL)) {
            return [
                'error' => true,
                'message' =>'Не корректный аргумент uri: %s'
            ];
        }

        $headers = @get_headers($uri);
        if(!$headers || !strpos( $headers[0], '200')) {
            return [
                'error' => true,
                'message' =>'По указанному адресу файла не существует.'
            ];
        }

        return ['error' => false];
    }
}
