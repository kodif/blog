<?php

namespace Kodify\BlogBundle\Features\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Kodify\BlogBundle\Entity\Author;
use Kodify\BlogBundle\Entity\Comment;
use Kodify\BlogBundle\Entity\Post;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    use KernelDictionary;

    /**
     * @BeforeScenario
     */
    public function cleanDB()
    {
        $entityManager = $this->getEntityManager();

        $entityManager->createQuery('DELETE KodifyBlogBundle:Comment')->execute();
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
        $session = $this->getMink()->getSession();

        $session->visit('/');
    }

    /**
     * @Then The post with title :title is on first column, first row
     */
    public function thePostWithTitleIsOnFirstColumnFirstRow($title)
    {
        $page = $this->getMink()->getSession()->getPage();
    }

    /**
     * @Then The post with title :title is on the second column, first row
     */
    public function thePostWithTitleIsOnTheSecondColumnFirstRow($title)
    {
        $page = $this->getMink()->getSession()->getPage();
    }

    /**
     * @Then The post with title :title is on the first column, second row
     */
    public function thePostWithTitleIsOnTheFirstColumnSecondRow($title)
    {
        $page = $this->getMink()->getSession()->getPage();
    }

    /**
     * @Given the following comments exist:
     */
    public function theFollowingCommentsExist(TableNode $table)
    {
        $entityManager = $this->getEntityManager();

        foreach ($table as $row) {
            $author = $entityManager->getRepository('KodifyBlogBundle:Author')->findOneBy(array('name' => $row['author']));
            $post = $entityManager->getRepository('KodifyBlogBundle:Post')->findOneBy(array('title' => $row['post title']));

            $comment= new Comment();
            $comment->setAuthor($author);
            $comment->setPost($post);
            $comment->setContent($row['text']);

            $entityManager->persist($comment);
        }

        $entityManager->flush();
    }

    /**
     * @Given I visit the page for the post with title :arg1
     */
    public function iVisitThePageForThePostWithTitle($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see a message saying there are no comments
     */
    public function iShouldSeeAMessageSayingThereAreNoComments()
    {
        throw new PendingException();
    }

    /**
     * @Then I should see a comments section with :arg1 comment
     */
    public function iShouldSeeACommentsSectionWithComment($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then The comment I see says :arg1
     */
    public function theCommentISeeSays($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I don't see the comment :arg1
     */
    public function iDonTSeeTheComment($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When I click on the button :arg1
     */
    public function iClickOnTheButton($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When I fill the form with :arg1
     */
    public function iFillTheFormWith($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then a comment should be created for the post with the provided data
     */
    public function aCommentShouldBeCreatedForThePostWithTheProvidedData()
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
