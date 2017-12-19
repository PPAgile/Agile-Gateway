<?php
/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Action\HomePageAction::class, 'home');
 * $app->post('/album', App\Action\AlbumCreateAction::class, 'album.create');
 * $app->put('/album/:id', App\Action\AlbumUpdateAction::class, 'album.put');
 * $app->patch('/album/:id', App\Action\AlbumUpdateAction::class, 'album.patch');
 * $app->delete('/album/:id', App\Action\AlbumDeleteAction::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Action\ContactAction::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

$app->get('/', App\Action\HomePageAction::class, 'home');
$app->get('/v1/ping', App\Action\PingAction::class, 'api.ping');
$app->get('/v1/like', App\Action\Likes\ListLikesAction::class, 'listlikes');
$app->get('/v1/posts', [ App\Middleware\CacheMiddleware::class, App\Action\Posts\ListPostsAction::class], 'listposts');
$app->get('/v1/comments', [ App\Middleware\CacheMiddleware::class, App\Action\Comments\ListCommentsAction::class], 'listcomments');
$app->post('/v1/like', App\Action\Likes\CreateLikeAction::class, 'createlike');
$app->post('/v1/post', App\Action\Posts\CreatePostAction::class, 'createpost');
$app->post('/v1/comment', App\Action\Comments\CreateCommentAction::class, 'createcomment');