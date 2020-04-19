<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $article = new Article();
        $article->setTitle('First Article');
        $article->setSummary('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $content = <<<EOF
        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.

        Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
        EOF;

        $article->setContent($content);
        $article->setCreated(new \DateTime());
        $article->setPublished(true);

        $manager->persist($article);


        $article = new Article();
        $article->setTitle('Second Article');
        $article->setSummary('Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur.');

        $content = <<<EOF
        At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.

        Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p><p>Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
        EOF;

        $article->setContent($content);
        $article->setCreated(new \DateTime());
        $article->setPublished(true);

        $manager->persist($article);



        $article = new Article();
        $article->setTitle('Third Article');
        $article->setSummary('Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur.');

        $content = <<<EOF
        # Country API

        The information about the API is shown below as follows.

        ## Authentication

        This API uses [OAuth 1.0a](https://oauth.net/core/1.0a/) so you need your "Consumer Key" and "Consumer Secret" to consume it.

        > Promotes a consistent and trusted experience for both application developers and the users of those applications.

        ## Endpoints

        ### COUNTRIES

        Endpoints deals with "Country" related data.

        ### Get one

        **Request**

        ```
        GET /countries/{country-guid}
        ```

        ** Request Requirements**

        | Parameter | Description | Properties | Example |
        | --- | --- | --- | --- |
        | `country-guid` | The GUID of the *country* resource | Required: `true`, Type: `string`| `123-ABC-8cw` |

        **Response**

        ```
        {
        "name": "Great Britain",
        "country_code": "GB"
        }
        ```

        **Response Codes**

        | Code | Meaning | Reason |
        | --- | --- | --- |
        | `200` | OK | Standard response for successful HTTP request. |
        | `400` | Bad Request | Something wrong with your request. |
        | `404` | Not Found | The resource you're looking for was not found. |
        EOF;
        $article->setContent($content);
        $article->setPublished(true);

        $manager->persist($article);

        $manager->flush();
    }
}
