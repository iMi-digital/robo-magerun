<?php
namespace iMi\RoboRun\Task\Conrun;

use Robo\Task\CommandStack;

/**
 * Runs Conrun commands in stack. You can use `stopOnFail()` to point that stack should be terminated on first fail.
 *
 * ``` php
 * <?php
 * $this->taskConrunStack()
 *  ->stopOnFail()
 *  ->exec('db:import master.sql')
 *  ->cacheFlush()
 *  ->run()
 *
 * ?>
 * ```
 */
class Stack extends CommandStack
{
	/**
	 * @param null|string $pathToConrun
	 *
	 * @throws \Robo\Exception\TaskException
	 */
	public function __construct($pathToConrun = null)
	{
		$this->executable = $pathToConrun;
		if (!$this->executable) {
			$this->executable = $this->findExecutablePhar('imi-conrun');
		}
		if (!$this->executable) {
			throw new TaskException(__CLASS__, "Neither local imi-conrun.phar nor global imi-conrun installation could be found.");
		}
	}

    /**
     * Executes `cache:flush`
     *
     * @param string $repo
     * @param string $to
     *
     * @return $this
     */
    public function cacheFlush()
    {
        return $this->exec(['cache:flush']);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo("Running Conrun commands...");
        return parent::run();
    }
}
