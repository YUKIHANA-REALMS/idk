<?php

namespace App\Core\Controller\Panel\Setting;

use App\Core\Controller\Panel\AbstractPanelController;
use App\Core\Entity\LandingPageSection;
use App\Core\Enum\CrudTemplateContextEnum;
use App\Core\Enum\PermissionEnum;
use App\Core\Enum\ViewNameEnum;
use App\Core\Service\Crud\PanelCrudService;
use App\Core\Service\LandingPage\LandingPageService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class LandingPageController extends AbstractPanelController
{
    public function __construct(
        PanelCrudService $panelCrudService,
        RequestStack $requestStack,
        private readonly LandingPageService $landingPageService,
        private readonly TranslatorInterface $translator,
        private readonly AdminUrlGenerator $adminUrlGenerator,
    ) {
        parent::__construct($panelCrudService, $requestStack);
    }

    public static function getEntityFqcn(): string
    {
        return LandingPageSection::class;
    }

    protected function getPermissionMapping(): array
    {
        return [
            Action::INDEX => PermissionEnum::ACCESS_ADMIN_OVERVIEW->value,
            'editSection' => PermissionEnum::EDIT_SETTINGS_GENERAL->value,
            'updateSection' => PermissionEnum::EDIT_SETTINGS_GENERAL->value,
            'toggleSection' => PermissionEnum::EDIT_SETTINGS_GENERAL->value,
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/index', 'panel/crud/landing_page/index.html.twig')
            ->setSearchFields(null);
    }

    public function index(AdminContext $context): Response
    {
        $request = $context->getRequest();

        $this->appendCrudTemplateContext(CrudTemplateContextEnum::SETTING->value);
        $this->appendCrudTemplateContext('landing_page');

        $sections = $this->landingPageService->getAllSections();

        return $this->renderWithEvent(
            ViewNameEnum::SETTING_LANDING_PAGE,
            'panel/crud/landing_page/index.html.twig',
            [
                'sections' => $sections,
                'page_title' => $this->translator->trans('indium.crud.landing_page.management'),
            ],
            $request
        );
    }

    public function editSection(AdminContext $context): Response
    {
        $request = $context->getRequest();
        $sectionType = $request->query->get('sectionType');

        $section = $this->landingPageService->getSection($sectionType);
        if ($section === null) {
            $this->addFlash('danger', 'Section not found');
            return $this->redirect($this->adminUrlGenerator
                ->setController(self::class)
                ->setAction('index')
                ->generateUrl());
        }

        $this->appendCrudTemplateContext(CrudTemplateContextEnum::SETTING->value);
        $this->appendCrudTemplateContext('landing_page');

        $templateMap = [
            'general' => 'panel/crud/landing_page/edit_general.html.twig',
            'navbar' => 'panel/crud/landing_page/edit_navbar.html.twig',
            'hero' => 'panel/crud/landing_page/edit_hero.html.twig',
            'features' => 'panel/crud/landing_page/edit_features.html.twig',
            'products' => 'panel/crud/landing_page/edit_products.html.twig',
            'cta' => 'panel/crud/landing_page/edit_cta.html.twig',
            'footer' => 'panel/crud/landing_page/edit_footer.html.twig',
        ];

        $template = $templateMap[$sectionType] ?? 'panel/crud/landing_page/edit_generic.html.twig';

        return $this->renderWithEvent(
            ViewNameEnum::SETTING_LANDING_PAGE,
            $template,
            [
                'section' => $section,
                'section_type' => $sectionType,
                'content' => $section->getContent(),
                'page_title' => $this->translator->trans('indium.crud.landing_page.edit_section', ['%section%' => $section->getTitle()]),
            ],
            $request
        );
    }

    public function updateSection(AdminContext $context): RedirectResponse
    {
        $request = $context->getRequest();
        $sectionType = $request->request->get('sectionType');
        $content = $request->request->all('content');
        $isEnabled = $request->request->has('isEnabled');

        // Handle nested arrays (like navbar links, hero buttons, feature items, etc.)
        $rawContent = $request->request->all();
        $content = $this->extractContent($rawContent);

        $this->landingPageService->saveSection(
            $sectionType,
            $content,
            isEnabled: $isEnabled
        );

        $this->addFlash('success', $this->translator->trans('indium.crud.landing_page.section_saved'));

        return $this->redirect($this->adminUrlGenerator
            ->setController(self::class)
            ->setAction('index')
            ->generateUrl());
    }

    public function toggleSection(AdminContext $context): RedirectResponse
    {
        $request = $context->getRequest();
        $sectionType = $request->query->get('sectionType');

        $this->landingPageService->toggleSection($sectionType);

        $this->addFlash('success', $this->translator->trans('indium.crud.landing_page.section_toggled'));

        return $this->redirect($this->adminUrlGenerator
            ->setController(self::class)
            ->setAction('index')
            ->generateUrl());
    }

    private function extractContent(array $raw): array
    {
        $content = [];

        if (isset($raw['content']) && is_array($raw['content'])) {
            foreach ($raw['content'] as $key => $value) {
                $content[$key] = $value;
            }
        }

        // Handle nested array structures (links, buttons, items, social_links)
        $nestedKeys = ['links', 'buttons', 'items', 'social_links', 'features'];
        foreach ($nestedKeys as $nestedKey) {
            if (isset($raw[$nestedKey]) && is_array($raw[$nestedKey])) {
                $content[$nestedKey] = [];
                $count = count(reset($raw[$nestedKey]) ?: []);
                for ($i = 0; $i < $count; $i++) {
                    $item = [];
                    foreach ($raw[$nestedKey] as $fieldKey => $fieldValues) {
                        if (isset($fieldValues[$i])) {
                            $item[$fieldKey] = $fieldValues[$i];
                        }
                    }
                    if (!empty($item)) {
                        $content[$nestedKey][] = $item;
                    }
                }
            }
        }

        // Handle direct nested keys in content
        if (isset($raw['content'])) {
            foreach ($raw['content'] as $key => $value) {
                if (is_array($value)) {
                    $content[$key] = $value;
                }
            }
        }

        return $content;
    }
}
