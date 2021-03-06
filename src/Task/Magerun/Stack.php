<?php
namespace iMi\RoboRun\Task\Magerun;

use Robo\Task\CommandStack;

/**
 * Runs Magerun commands in stack. You can use `stopOnFail()` to point that stack should be terminated on first fail.
 *
 * ``` php
 * <?php
 * $this->taskMagerunStack()
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
	 * @param null|string $pathToMagerun
	 *
	 * @throws \Robo\Exception\TaskException
	 */
	public function __construct($pathToMagerun = null)
	{
		$this->executable = $pathToMagerun;
		if (!$this->executable) {
			$this->executable = $this->findExecutablePhar('n98-magerun');
		}
		if (!$this->executable) {
			throw new TaskException(__CLASS__, "Neither local n98-magerun.phar nor global n98-magerun installation could be found.");
		}
	}

    /**
     * Executes `git clone`
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
        $this->printTaskInfo("Running Magerun commands...");
        return parent::run();
    }
}
