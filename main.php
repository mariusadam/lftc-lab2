<?php

use Command\Composite;

require_once __DIR__.'/vendor/autoload.php';

$mainCmd = new Composite('', 'Actions on: ');
$mainCmd->setApplicationState(new ApplicationState());

$grammarCmd = new Composite('g', 'Grammar');
$grammarCmd->addCommand(new \Command\Grammar\Read('r'));
$grammarCmd->addCommand(new \Command\Grammar\IsRegular('isr'));
$grammarCmd->addCommand(new \Command\Grammar\Details('d'));
$grammarCmd->addCommand(new \Command\Grammar\ToFiniteAutomate('to-fa'));
$grammarCmd->addCommand(new \Command\Grammar\ShowLoaded('list'));

$finiteAutomateCmd = new Composite('f', 'Finite Automate');
$finiteAutomateCmd->addCommand(new \Command\FiniteAutomate\Read('r'));
$finiteAutomateCmd->addCommand(new \Command\FiniteAutomate\Details('d'));
$finiteAutomateCmd->addCommand(new \Command\FiniteAutomate\ToGrammar('to-gr'));
$finiteAutomateCmd->addCommand(new \Command\FiniteAutomate\ShowLoaded('list'));

$mainCmd->addCommand($grammarCmd);
$mainCmd->addCommand($finiteAutomateCmd);

$mainCmd->execute();