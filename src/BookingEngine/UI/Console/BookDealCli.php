<?php

namespace Afsy\BookingEngine\UI\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Afsy\BookingEngine\App\BookingService;
use Afsy\BookingEngine\App\BookDealCommand;

class BookDealCli extends Command
{
    private $bookingService;

    public function __construct(BookingService $bookingService)
    {
        parent::__construct();
        $this->bookingService = $bookingService;
    }

    protected function configure()
    {
        $this
            ->setName('afsy:booking:book-deal')
            ->addArgument('dealId', InputArgument::REQUIRED, 'Deal ID')
            ->addArgument('customerId', InputArgument::REQUIRED, 'Customer ID')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bookingService->bookDeal(
            new BookDealCommand(
                $input->getArgument('dealId'),
                $input->getArgument('customerId')
            )
        );
    }
}
