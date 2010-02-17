<?php

return array(
	'name'=>'Hangman Game',
	'defaultController'=>'game',
	'components'=>array(
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'hello/<g:\w>'=>'play',
			),
		),
	),
);