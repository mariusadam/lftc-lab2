<?php


namespace Command;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class Composite extends \Command
{
    /**
     * @var array|\Command[]
     */
    private $commands;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Command
     */
    private $lastExecuted;

    /**
     * @var bool
     */
    private $loopForever;

    /**
     * Composite constructor.
     *
     * @param string $name
     * @param string $description
     */
    public function __construct(string $name, string $description)
    {
        parent::__construct($name);
        $this->description = $description;
        $this->commands = [];
        $this->setLoopForever(true);
        $this->addCommand(new GoBack('x'));
    }

    /**
     * @param \Command $command
     */
    public function addCommand(\Command $command)
    {
        if (isset($this->commands[$command->getName()])) {
            throw new \InvalidArgumentException('Command already defined.');
        }

        $this->commands[$command->getName()] = $command;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Execute the current command
     */
    public function execute()
    {
        $this->configureCommands();

        $separator = str_repeat('=', 50);
        while (true) {
            $this->writeln($separator);
            $this->writeln('');
            $this->writeln($this->getDescription());
            foreach ($this->commands as $command) {
                $this->writeln(
                    '    '.sprintf(
                        '%s => %s',
                        str_pad($command->getName(), self::NAME_MAX_LEN),
                        $command->getDescription()
                    )
                );
            }

            $cmdName = $this->readline('cmd = ');

            $this->writeln($separator);
            if ($cmdName === null || !isset($this->commands[$cmdName])) {
                $this->writeln('Invalid command '.$cmdName.'.');
                continue;
            }

            $actualCmd = $this->commands[$cmdName];
            if ($actualCmd instanceof GoBack) {
                $this->writeln('Leaving current context...');
                break;
            }
            $this->lastExecuted = $actualCmd;
            try {
                $actualCmd->execute();
            } catch (\Exception $e) {
//                $this->writeln($e->getTraceAsString());
                $this->writeln($e->getMessage());
            }

            if (!$this->loopForever) {
                break;
            }
        }
    }

    /**
     * @return \Command|null
     */
    public function getLastExecuted()
    {
        return $this->lastExecuted;
    }

    private function configureCommands()
    {
        if (!$this->hasApplicationState()) {
            return;
        }

        foreach ($this->commands as $command) {
            $command->setApplicationState($this->getApplicationState());
        }
    }

    /**
     * @return array|\Command[]
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * @param bool $loopForever
     */
    public function setLoopForever(bool $loopForever)
    {
        $this->loopForever = $loopForever;
    }
}