<?php


abstract class Command
{
    /**
     * @const
     */
    const NAME_MAX_LEN = 7;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ApplicationState
     */
    private $applicationState;

    /**
     * Command constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        if (strlen($name) > self::NAME_MAX_LEN) {
            throw new InvalidArgumentException();
        }

        $this->name = $name;
    }

    /**
     * @param \ApplicationState $applicationState
     *
     * @return static
     */
    public static function create(\ApplicationState $applicationState)
    {
        $cmd = new static('');
        $cmd->setApplicationState($applicationState);

        return $cmd;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        $fqcn =  get_class($this);
        $parts = explode('\\', $fqcn);
        return end($parts);
    }

    /**
     * Execute the current command
     */
    abstract public function execute();

    /**
     * @param ApplicationState $applicationState
     *
     * @return Command
     */
    public function setApplicationState(ApplicationState $applicationState
    ): Command {
        $this->applicationState = $applicationState;

        return $this;
    }

    /**
     * @return ApplicationState
     */
    public function getApplicationState(): ApplicationState
    {
        return $this->applicationState;
    }

    /**
     * @return bool
     */
    public function hasApplicationState(): bool
    {
        return null !== $this->applicationState;
    }

    /**
     * @param string $str
     */
    protected function writeln(string $str)
    {
        $this->write($str.PHP_EOL);
    }

    /**
     * @param string $str
     */
    public function write(string $str)
    {
        echo $str;
    }

    /**
     * @param string $prompt
     *
     * @return string
     */
    protected function readline($prompt = '')
    {
        $result = readline($prompt);
        readline_add_history($result);
        return $result;
    }
}