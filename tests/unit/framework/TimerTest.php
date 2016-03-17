<?php

class TimerTest extends \Codeception\TestCase\Test
{
	function testStartStop()
	{
		$t1 = microtime(true);
		$started = Rhymix\Framework\Timer::start();
		$t2 = microtime(true);
		$elapsed = Rhymix\Framework\Timer::stop();
		$t3 = microtime(true);
		
		$this->assertGreaterThanOrEqual($t1, $started);
		$this->assertLessThanOrEqual($t2, $started);
		$this->assertGreaterThanOrEqual($t2 - $started, $elapsed);
		$this->assertLessThanOrEqual($t3 - $t1, $elapsed);
		$this->assertGreaterThan(0, $elapsed);
	}
	
	function testNestedTimers()
	{
		$t1 = Rhymix\Framework\Timer::start();
		$t2 = Rhymix\Framework\Timer::start();
		$t3 = Rhymix\Framework\Timer::stop();
		$t4 = Rhymix\Framework\Timer::stop();
		
		$this->assertGreaterThanOrEqual($t1, $t2);
		$this->assertGreaterThan($t4, $t3);
	}
	
	function testMultipleTimers()
	{
		$t1 = Rhymix\Framework\Timer::start('timer1');
		usleep(5000);
		$t2 = Rhymix\Framework\Timer::start('timer2');
		
		$t3 = Rhymix\Framework\Timer::stop('timer1');
		usleep(2000);
		$t4 = Rhymix\Framework\Timer::stop('timer2');
		
		$this->assertGreaterThanOrEqual($t1, $t2);
		$this->assertGreaterThanOrEqual($t4, $t3);
	}
	
	function testTimerFormat()
	{
		$t1 = Rhymix\Framework\Timer::start();
		$t2 = Rhymix\Framework\Timer::stopFormat();
		
		$this->assertRegexp('/^[0-9\.,]+ms$/', $t2);
	}
	
	function testTimerSinceStartup()
	{
		$t1 = Rhymix\Framework\Timer::sinceStartup();
		$t2 = Rhymix\Framework\Timer::sinceStartup();
		
		$this->assertGreaterThanOrEqual($t1, $t2);
		
		$t3 = Rhymix\Framework\Timer::sinceStartupFormat();
		$this->assertRegexp('/^[0-9\.,]+ms$/', $t3);
	}
}
