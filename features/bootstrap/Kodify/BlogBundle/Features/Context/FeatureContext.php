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
            $author = $this->getAuthorByName($row['author']);

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
        $this->visit('/');
    }

    /**
     * @Then The post with title :title is on first column, first row
     */
    public function thePostWithTitleIsOnFirstColumnFirstRow($title)
    {
        $this->assertPageContainsText($title);
    }

    /**
     * @Then The post with title :title is on the second column, first row
     */
    public function thePostWithTitleIsOnTheSecondColumnFirstRow($title)
    {
        $this->assertPageContainsText($title);
    }

    /**
     * @Then The post with title :title is on the first column, second row
     */
    public function thePostWithTitleIsOnTheFirstColumnSecondRow($title)
    {
        $this->assertPageContainsText($title);
    }

    /**
     * @Given the following comments exist:
     */
    public function theFollowingCommentsExist(TableNode $table)
    {
        $entityManager = $this->getEntityManager();

        foreach ($table as $row) {
            $author = $this->getAuthorByName($row['author']);
            $post = $this->getPostByTitle($row['post title']);

            $comment= new Comment();
            $comment->setAuthor($author);
            $comment->setPost($post);
            $comment->setContent($row['text']);

            $entityManager->persist($comment);
        }

        $entityManager->flush();
    }

    /**
     * @Given I visit the page for the post with title :title
     */
    public function iVisitThePageForThePostWithTitle($title)
    {
        $entityManager = $this->getEntityManager();

        $post = $this->getPostByTitle($title, $entityManager);

        $url = '/posts/' . $post->getId();

        $this->visit($url);
    }

    /**
     * @Then I should see a message saying there are no comments
     */
    public function iShouldSeeAMessageSayingThereAreNoComments()
    {
        $this->assertPageContainsText('No comments');
    }

    /**
     * @Then I should see a comments section with :arg1 comment
     */
    public function iShouldSeeACommentsSectionWithComment($content)
    {
        $this->assertPageNotContainsText('No comments');
    }

    /**
     * @Then The comment I see says :content
     */
    public function theCommentISeeSays($content)
    {
        $this->assertPageContainsText($content);
    }

    /**
     * @Then I don't see the comment :content
     */
    public function iDonTSeeTheComment($content)
    {
        $this->assertPageNotContainsText($content);
    }

    /**
     * @When I click on the button :buttonText
     */
    public function iClickOnTheButton($buttonText)
    {
        $this->clickLink($buttonText);
    }

    /**
     * @When I fill the form with :data
     */
    public function iFillTheFormWith($data)
    {
        $fields = json_decode(str_replace("'", '"', $data), true);

        $author = $this->getAuthorByName($fields['author']);

        $this->fillField('Comment_content', $fields['text']);
        $this->fillField('Comment_author', $author->getId());
    }

    /**
     * @Then a comment should be created for the post with the provided data
     */
    public function aCommentShouldBeCreatedForThePostWithTheProvidedData()
    {
        $this->assertPageContainsText('Comment Created!');
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    private function getEntityManager()
    {
        return $this->getContainer()->get('doctrine')->getManager();
    }

    /**
     * @param string $title
     *
     * @return Post
     */
    private function getPostByTitle($title)
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->getRepository('KodifyBlogBundle:Post')->findOneBy(array('title' => $title));
    }

    /**
     * @param string $name
     *
     * @return Author
     */
    private function getAuthorByName($name)
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->getRepository('KodifyBlogBundle:Author')->findOneBy(array('name' => $name));
    }
}
