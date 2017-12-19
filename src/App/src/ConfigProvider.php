<?php

namespace App;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
                Action\PingAction::class => Action\PingAction::class,
            ],
            'factories'  => [
                Action\HomePageAction::class => Action\HomePageFactory::class,
                Action\Likes\ListLikesAction::class => Action\Likes\ListLikesFactory::class,
                Action\Likes\CreateLikeAction::class => Action\Likes\CreateLikeFactory::class,
                Action\Posts\CreatePostAction::class => Action\Posts\CreatePostFactory::class,
                Action\Posts\ListPostsAction::class => Action\Posts\ListPostsFactory::class,
                Action\Comments\ListCommentsAction::class => Action\Comments\ListCommentsFactory::class,
                Action\Comments\CreateCommentAction::class => Action\Comments\CreateCommentFactory::class,
            ],
        ];
    }
}
