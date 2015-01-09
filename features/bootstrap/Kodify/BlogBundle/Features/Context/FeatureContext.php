<?php

namespace Kodify\BlogBundle\Features\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    use KernelDictionary;


    /**
     * @Given the following authors exist:
     */
    public function theFollowingAuthorsExist(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given the following posts exist:
     */
    public function theFollowingPostsExist(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given I visit the home page
     */
    public function iVisitTheHomePage()
    {
        throw new PendingException();
    }

    /**
     * @Then The post with title :arg1 is on first column, first row
     */
    public function thePostWithTitleIsOnFirstColumnFirstRow($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then The post with title :arg1 is on the second column, first row
     */
    public function thePostWithTitleIsOnTheSecondColumnFirstRow($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then The post with title :arg1 is on the first column, second row
     */
    public function thePostWithTitleIsOnTheFirstColumnSecondRow($arg1)
    {
        throw new PendingException();
    }
}
