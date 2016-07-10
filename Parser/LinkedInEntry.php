<?php
namespace Gacek85\LinkedInCrawler\Parser;

/**
 *  Represents a parsed LinkedIn entry
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class LinkedInEntry 
{
    protected $first_name           = null;
    
    protected $last_name            = null;
    
    protected $name                 = null;
    
    protected $title                = null;
    
    protected $summary              = null;
    
    protected $location             = null;
    
    protected $country              = null;
    
    protected $industry             = null;
    
    protected $picture              = null;
    
    protected $skills               = array();
    
    protected $past_companies       = array();
    
    protected $current_companies    = array();
    
    protected $organizations        = array();
    
    protected $education            = array();
    
    protected $websites             = array();
    
    protected $groups               = array();
    
    protected $languages            = array();
    
    protected $certifications       = array();
    
    
    /**
     * Returns the first_name string
     * 
     * @return      string
     */
    public function getFirstName ()
    {
        return $this->first_name;
    }

    
    /**
     * Returns the last_name string
     * 
     * @return      string
     */
    public function getLastLame ()
    {
        return $this->last_name;
    }

    
    /**
     * Returns the name string
     * 
     * @return      string
     */
    public function getName ()
    {
        return $this->name;
    }

    
    /**
     * Returns the title string
     * 
     * @return      string
     */
    public function getTitle ()
    {
        return $this->title;
    }

    
    /**
     * Returns the summary string
     * 
     * @return      string
     */
    public function getSummary ()
    {
        return $this->summary;
    }

    
    /**
     * Returns the location string
     * 
     * @return      string
     */
    public function getLocation ()
    {
        return $this->location;
    }

    
    /**
     * Returns the country string
     * 
     * @return      string
     */
    public function getCountry ()
    {
        return $this->country;
    }
    
    
    /**
     * Returns the industry string
     * 
     * @return      string
     */
    public function getIndustry ()
    {
        return $this->industry;
    }

    
    /**
     * Returns the picture string
     * 
     * @return      string
     */
    public function getPicture ()
    {
        return $this->picture;
    }

    
    /**
     * Returns an array of skills 
     * 
     * @return      array       An array of strings
     */
    public function getSkills ()
    {
        return $this->skills;
    }
    
    
    /**
     * Returns an array of past_companies 
     * 
     * @return      array       An array of strings
     */
    public function getPastCompanies ()
    {
        return $this->past_companies;
    }

    
    /**
     * Returns an array of current_companies 
     * 
     * @return      array       An array of strings
     */
    public function getCurrentCompanies ()
    {
        return $this->current_companies;
    }
    
    
    /**
     * Returns an array of organizations 
     * 
     * @return      array       An array of strings
     */
    public function getOrganizations ()
    {
        return $this->organizations;
    }

    
    /**
     * Returns an array of education 
     * 
     * @return      array       An array of strings
     */
    public function getEducation ()
    {
        return $this->education;
    }

    
    /**
     * Returns an array of websites 
     * 
     * @return      array       An array of strings
     */
    public function getWebsites ()
    {
        return $this->websites;
    }

    
    /**
     * Returns an array of groups 
     * 
     * @return      array       An array of strings
     */
    public function getGroups ()
    {
        return $this->groups;
    }

    
    /**
     * Returns an array of languages 
     * 
     * @return      array       An array of strings
     */
    public function getLanguages ()
    {
        return $this->languages;
    }

    
    /**
     * Returns an array of certifications 
     * 
     * @return      array       An array of strings
     */
    public function getCertifications ()
    {
        return $this->certifications;
    }

    
    /**
     * Sets the first_name
     * 
     * @param       string              $first_name
     * @return      LinkedInEntry       This instance
     */
    public function setFirstName ($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    
    /**
     * Sets the last_name
     * 
     * @param       string              $last_name
     * @return      LinkedInEntry       This instance
     */
    public function setLastName ($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }

    
    /**
     * Sets the name
     * 
     * @param       string              $name
     * @return      LinkedInEntry       This instance
     */
    public function setName ($name)
    {
        $this->name = $name;
        return $this;
    }

    
    /**
     * Sets the title
     * 
     * @param       string              $title
     * @return      LinkedInEntry       This instance
     */
    public function setTitle ($title)
    {
        $this->title = $title;
        return $this;
    }

    
    /**
     * Sets the summary
     * 
     * @param       string              $summary
     * @return      LinkedInEntry       This instance
     */
    public function setSummary ($summary)
    {
        $this->summary = $summary;
        return $this;
    }

    
    /**
     * Sets the location
     * 
     * @param       string              $location
     * @return      LinkedInEntry       This instance
     */
    public function setLocation ($location)
    {
        $this->location = $location;
        return $this;
    }

    
    /**
     * Sets the country
     * 
     * @param       string              $country
     * @return      LinkedInEntry       This instance
     */
    public function setCountry ($country)
    {
        $this->country = $country;
        return $this;
    }

    
    /**
     * Sets the industry
     * 
     * @param       string              $industry
     * @return      LinkedInEntry       This instance
     */
    public function setIndustry ($industry)
    {
        $this->industry = $industry;
        return $this;
    }

    
    /**
     * Sets the picture
     * 
     * @param       string              $picture
     * @return      LinkedInEntry       This instance
     */
    public function setPicture ($picture)
    {
        $this->picture = $picture;
        return $this;
    }

    
    /**
     * Sets the skills
     * 
     * @param       array               $skills
     * @return      LinkedInEntry       This instance
     */
    public function setSkills (array $skills)
    {
        $this->skills = $skills;
        return $this;
    }
    
    
    /**
     * Sets the past_companies
     * 
     * @param       array               $past_companies
     * @return      LinkedInEntry       This instance
     */
    public function setPastCompanies (array $past_companies)
    {
        $this->past_companies = $past_companies;
        return $this;
    }
    
    
    /**
     * Sets the current_companies
     * 
     * @param       array               $current_companies
     * @return      LinkedInEntry       This instance
     */
    public function setCurrentCompanies (array $current_companies)
    {
        $this->current_companies = $current_companies;
        return $this;
    }

    
    /**
     * Sets the organizations
     * 
     * @param       array               $organizations
     * @return      LinkedInEntry       This instance
     */
    public function setOrganizations (array $organizations)
    {
        $this->organizations = $organizations;
        return $this;
    }

    
    /**
     * Sets the education
     * 
     * @param       array               $education
     * @return      LinkedInEntry       This instance
     */
    public function setEducation (array $education)
    {
        $this->education = $education;
        return $this;
    }

    
    /**
     * Sets the websites
     * 
     * @param       array               $websites
     * @return      LinkedInEntry       This instance
     */
    public function setWebsites (array $websites)
    {
        $this->websites = $websites;
        return $this;
    }

    
    /**
     * Sets the groups
     * 
     * @param       array               $groups
     * @return      LinkedInEntry       This instance
     */
    public function setGroups (array $groups)
    {
        $this->groups = $groups;
        return $this;
    }

    
    /**
     * Sets the languages
     * 
     * @param       array               $languages
     * @return      LinkedInEntry       This instance
     */
    public function setLanguages (array $languages)
    {
        $this->languages = $languages;
        return $this;
    }

    
    /**
     * Sets the certifications
     * 
     * @param       array               $certifications
     * @return      LinkedInEntry       This instance
     */
    public function setCertifications (array $certifications)
    {
        $this->certifications = $certifications;
        return $this;
    }
    
    
    /**
     * Returns an array of all available fields
     */
    public function toArray ()
    {
        return array(
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name' => $this->name,
            'title' => $this->title,
            'summary' => $this->summary,
            'location' => $this->location,
            'country' => $this->country,
            'industry' => $this->industry,
            'picture' => $this->picture,
            'skills' => $this->skills ?: array(),
            'past_companies' => $this->past_companies ?: array(),
            'current_companies' => $this->current_companies ?: array(),
            'organizations' => $this->organizations ?: array(),
            'education' => $this->education  ?: array(),
            'websites' => $this->websites  ?: array(),
            'groups' => $this->groups ?: array(),
            'languages' => $this->languages ?: array(),
            'certifications' => $this->certifications ?: array(),
        );
    }
}