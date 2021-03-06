<?php

namespace spec\Roboxt;

use PhpSpec\Exception\Example\PendingException;
use PhpSpec\ObjectBehavior;

class ParserSpec extends ObjectBehavior
{
    function it_should_read_a_robots_txt_file()
    {
        $content = <<<TEXT
User-Agent: *
Disallow: /foo
Allow: /baz
Allow: /bar
Sitemap: /sitemap.xml

User-agent: Googlebot-News
Disallow: /foo
Allow: /baz
TEXT;

        $this->read(__DIR__.'/../fixtures/robots.txt')->shouldReturn($content);
    }

    function it_should_parse_the_robots_txt_file_and_return_a_directives_collections()
    {
        $file = $this->parse(__DIR__.'/../fixtures/robots.txt');

        $file->shouldReturnAnInstanceOf('Roboxt\File');
        $file->allUserAgents()->shouldHaveCount(2);

        $googlebot = $file->getUserAgent('Googlebot-News');
        $googlebot->shouldBeAnInstanceOf('Roboxt\UserAgent');
        $googlebot->allDirectives()->shouldHaveCount(2);
    }
}
