<?php
namespace MNAddDocumentImages;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;

class MNAddDocumentImages extends \Shopware\Components\Plugin
{
    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache(ActivateContext::CACHE_LIST_DEFAULT);
    }
    public function deactivate(DeactivateContext $context)
    {
        $context->scheduleClearCache(DeactivateContext::CACHE_LIST_DEFAULT);
    }

    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Components_Document::assignValues::after' => 'addAttributes'
        ];
    }

    public function addAttributes(\Enlight_Hook_HookArgs $args)
    {
        /* @var \Shopware_Components_Document $document */
        $document = $args->getSubject();
        $view = $document->_view;
        $positionNumber = 0;
        $positionsNumber = 0;

        $orderData = $view->getTemplateVars('Pages');

        foreach($orderData as $positions)
        {

            foreach($positions as $position)
            {
                if($position['modus'] != 0)
                {
                }
                else
                {
                    $article = Shopware()->Modules()->Articles()->sGetArticleById($position['articleID']);
                    $article = Shopware()->Modules()->Articles()->sGetConfiguratorImage($article);
                    $orderData[$positionsNumber][$positionNumber]['image'] = $article['image']['thumbnails']['0']['source'];
                }

                $positionNumber++;
            }
            $positionsNumber++;
        }
        $view->assign('Pages', $orderData);
    }
}