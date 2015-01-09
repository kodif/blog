<?php

namespace Kodify\BlogBundle\Features\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Kodify\BlogBundle\Entity\Author;
use Kodify\BlogBundle\Entity\Post;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    use KernelDictionary;

    /**
     * @BeforeScenario
     */
    public function cleanDB()
    {
        $entityManager = $this->getEntityManager();

        $entityManager->createQuery('DELETE KodifyBlogBundle:Post')->execute();
        $entityManager->createQuery('DELETE KodifyBlogBundle:Author')->execute();

        $entityManager->flush();
    }

    /**
     * @Given the following authors exist:
     */
    public function theFollowingAuthorsExist(TableNode $table)
    {
        $entityManager = $this->getEntityManager();

        foreach ($table as $row) {
            $author = new Author();
            $author->setName($row['name']);
            $entityManager->persist($author);
        }

        $entityManager->flush();
    }

    /**
     * @Given the following posts exist:
     */
    public function theFollowingPostsExist(TableNode $table)
    {
        $entityManager = $this->getEntityManager();

        foreach ($table as $row) {
            $author = $entityManager->getRepository('KodifyBlogBundle:Author')->findOneBy(array('name' => $row['author']));

            $post = new Post();
            $post->setTitle($row['title']);
            $post->setContent($row['content']);
            $post->setAuthor($author);

            $entityManager->persist($post);
        }

        $entityManager->flush();
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

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    private function getEntityManager()
    {
        return $this->getContainer()->get('doctrine')->getManager();
    }
}
