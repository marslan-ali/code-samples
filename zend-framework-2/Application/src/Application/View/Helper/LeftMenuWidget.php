<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Project\Model\ProjectSiteTable;
use Project\Model\ProjectTable;
use Campaign\Model\CampaignTable;
use Zend\Authentication\AuthenticationService;
class LeftMenuWidget extends AbstractHelper
{
    protected $siteTable;
    protected $projectTable;
    protected $campaignTable;
    public function __construct(ProjectSiteTable $siteTable,ProjectTable $projectTable,CampaignTable $campaignTable)
    {
        if(!$this->siteTable)
        {
            $this->siteTable = $siteTable;                
        }
        if(!$this->projectTable)
        {
            $this->projectTable = $projectTable;
        }
        if(!$this->campaignTable)
        {
            $this->campaignTable = $campaignTable;
        }
    }
    
    public function __invoke()
    {
        $auth = new AuthenticationService;
        $accountId = $auth->getIdentity()->account_id;
        $sites = array();
        $campaigns = array();
        $projects = $this->projectTable->getUserProjects($accountId);

        if(!empty($projects))
        {                
            foreach($projects as $project)
            {
                $rowset = $this->siteTable->getSites($project->id);
                foreach($rowset as $row)
                {
                    $camp = $this->campaignTable->getSiteCampaignModuleDetails($row->id);
                    if(!empty($camp))
                    {
                        $campaigns[$row->id] = $camp;
                    }
                }
                
                $sites[$project->id] = $this->siteTable->getSites($project->id);
            }
            // to fix rewind error
            $projects = $this->projectTable->getUserProjects($accountId);
        }
        return $this->getView()->render('application/leftmenu/display',array('projects'=>$projects,'sites'=>$sites,'campaigns'=>$campaigns));
    }
}