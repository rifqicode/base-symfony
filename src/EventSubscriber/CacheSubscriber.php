<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Skeleton\EventSubscriber;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class CacheSubscriber implements EventSubscriberInterface
{
    private $cacheProvider;

    public function __construct(AdapterInterface $cacheProvider)
    {
        $this->cacheProvider = $cacheProvider;
    }

    public function invalidate(RequestEvent $event)
    {
        $request = $event->getRequest();
        if ($request->isMethod('POST') && $request->isXmlHttpRequest()) {
            $cacheId = $request->request->get('_cache_id');
            if (!$cacheId) {
                return;
            }

            $this->cacheProvider->deleteItem($cacheId);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => 'invalidate',
        ];
    }
}
