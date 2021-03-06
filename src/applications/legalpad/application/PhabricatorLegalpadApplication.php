<?php

final class PhabricatorLegalpadApplication extends PhabricatorApplication {

  public function getBaseURI() {
    return '/legalpad/';
  }

  public function getName() {
    return pht('Legalpad');
  }

  public function getShortDescription() {
    return pht('Agreements and Signatures');
  }

  public function getFontIcon() {
    return 'fa-gavel';
  }

  public function getTitleGlyph() {
    return "\xC2\xA9";
  }

  public function getApplicationGroup() {
    return self::GROUP_UTILITIES;
  }

  public function getRemarkupRules() {
    return array(
      new LegalpadDocumentRemarkupRule(),
    );
  }

  public function getHelpDocumentationArticles(PhabricatorUser $viewer) {
    return array(
      array(
        'name' => pht('Legalpad User Guide'),
        'href' => PhabricatorEnv::getDoclink('Legalpad User Guide'),
      ),
    );
  }

  public function getOverview() {
    return pht(
      '**Legalpad** is a simple application for tracking signatures and '.
      'legal agreements. At the moment, it is primarily intended to help '.
      'open source projects keep track of Contributor License Agreements.');
  }

  public function getRoutes() {
    return array(
      '/L(?P<id>\d+)' => 'LegalpadDocumentSignController',
      '/legalpad/' => array(
        '' => 'LegalpadDocumentListController',
        '(?:query/(?P<queryKey>[^/]+)/)?' => 'LegalpadDocumentListController',
        'create/' => 'LegalpadDocumentEditController',
        'edit/(?P<id>\d+)/' => 'LegalpadDocumentEditController',
        'comment/(?P<id>\d+)/' => 'LegalpadDocumentCommentController',
        'view/(?P<id>\d+)/' => 'LegalpadDocumentManageController',
        'done/' => 'LegalpadDocumentDoneController',
        'verify/(?P<code>[^/]+)/'
          => 'LegalpadDocumentSignatureVerificationController',
        'signatures/(?:(?P<id>\d+)/)?(?:query/(?P<queryKey>[^/]+)/)?'
          => 'LegalpadDocumentSignatureListController',
        'addsignature/(?P<id>\d+)/' => 'LegalpadDocumentSignatureAddController',
        'signature/(?P<id>\d+)/' => 'LegalpadDocumentSignatureViewController',
        'document/' => array(
          'preview/' => 'PhabricatorMarkupPreviewController',
        ),
      ),
    );
  }

  protected function getCustomCapabilities() {
    return array(
      LegalpadCreateDocumentsCapability::CAPABILITY => array(),
      LegalpadDefaultViewCapability::CAPABILITY => array(
        'template' => PhabricatorLegalpadDocumentPHIDType::TYPECONST,
      ),
      LegalpadDefaultEditCapability::CAPABILITY => array(
        'template' => PhabricatorLegalpadDocumentPHIDType::TYPECONST,
      ),
    );
  }

  public function getMailCommandObjects() {
    return array(
      'document' => array(
        'name' => pht('Email Commands: Legalpad Documents'),
        'header' => pht('Interacting with Legalpad Documents'),
        'object' => new LegalpadDocument(),
        'summary' => pht(
          'This page documents the commands you can use to interact with '.
          'documents in Legalpad.'),
      ),
    );
  }

}
