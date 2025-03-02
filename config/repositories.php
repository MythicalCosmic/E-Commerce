<?php

return [
	\App\Repositories\User\UserInterface::class => \App\Repositories\User\UserRepository::class,
	\App\Repositories\User\CategoryInterface::class => \App\Repositories\User\CategoryRepository::class,
	\App\Repositories\Category\CategoryInterface::class => \App\Repositories\Category\CategoryRepository::class,

];
