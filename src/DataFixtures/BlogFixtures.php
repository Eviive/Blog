<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoryNames = [
            'Languages',
            'Web',
            'Mobile',
            'Databases',
            'DevOps',
            'AI',
            'Cybersecurity',
            'Career',
            'Snippets',
            'Cloud',
        ];

        foreach ($categoryNames as $i => $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $this->addReference("category_$i", $category);
        }

        $pythonJavascriptPost = new Post();
        $pythonJavascriptPost->setTitle('Python vs. JavaScript: Which Language to Choose for Your Next Project');
        $pythonJavascriptPost->setDescription('A comparison of two popular programming languages, Python and JavaScript, and their strengths and weaknesses for various types of projects.');
        $pythonJavascriptPost->setContent('<h2>Introduction</h2><p><strong>Python </strong>and <strong>JavaScript </strong>are two of the most popular programming languages used today. Both have their strengths and weaknesses, and choosing the right language for your project can be a difficult decision. In this article, we&#039;ll compare Python and JavaScript in various aspects to help you decide which language to choose for your next project.</p><h2>Application Domain</h2><p>Python is a general-purpose language that is widely used in scientific computing, data analysis, machine learning, and artificial intelligence applications. It is also used for web development, game development, desktop application development, and system scripting. JavaScript, on the other hand, is mainly used for web development, including front-end and back-end development, and increasingly used for server-side applications.</p><h2>Syntax</h2><p>Python has a simple and easy-to-learn syntax, making it ideal for beginners. It uses indentation to define code blocks, making the code more readable. JavaScript syntax is similar to C and C&#43;&#43;, making it slightly more difficult to learn than Python. JavaScript also has more complex syntax for defining functions and object-oriented programming.</p><h2>Performance</h2><p>Python is an interpreted language, which means that it is slower than compiled languages such as C&#43;&#43; and Java. However, Python has many libraries and frameworks that can improve its performance for specific applications. JavaScript is also an interpreted language, but it is designed to run in web browsers, which limits its performance. However, JavaScript can be optimized for performance through techniques such as code minification, bundling, and just-in-time (JIT) compilation. JIT compilation involves compiling code at runtime, which can significantly improve performance. Python&#039;s performance can also be improved by using tools such as PyPy, which is an alternative interpreter that can provide a speed boost for certain applications.</p><p>Additionally, Python has libraries such as NumPy and SciPy that are optimized for numerical calculations and scientific computing, making them ideal for data analysis and machine learning applications. JavaScript&#039;s performance can be further improved by using modern frameworks such as React and Vue.js, which use virtual DOM and other techniques to optimize rendering speed. Node.js, a popular JavaScript runtime environment, also allows developers to build high-performance server-side applications. In terms of raw performance, C&#43;&#43; and Java are generally faster than both Python and JavaScript. However, the performance differences may not be significant for many applications, and the ease of development and availability of libraries and frameworks in Python and JavaScript may outweigh any performance benefits of using a compiled language.</p><h2>Conclusion</h2><p>Ultimately, the choice between Python and JavaScript will depend on the specific requirements of your project. If you are working on a data analysis or machine learning application, or if you need to build a complex desktop application, Python may be the better choice. If you are developing a web application or server-side application, JavaScript may be the more suitable language. However, both languages are versatile and can be used for a wide range of applications, so it&#039;s worth considering both options before making a decision.</p>');
        $pythonJavascriptPost->setSlug('python-vs-javaScript-which-language-to-choose-for-your-next-project');
        $pythonJavascriptPost->setCreatedAt(new \DateTimeImmutable('2023-03-08'));
        $pythonJavascriptPost->setPublishedAt(new \DateTimeImmutable('2023-03-08'));
        $pythonJavascriptPostCategories = [
            $this->getReference('category_0'),
            $this->getReference('category_1'),
        ];
        foreach ($pythonJavascriptPostCategories as $category) {
            $pythonJavascriptPost->addCategory($category);
        }
        $manager->persist($pythonJavascriptPost);

        $cppPost = new Post();
        $cppPost->setTitle('Learning C++: Tips for Beginners');
        $cppPost->setDescription('A list of tips and resources for beginners who want to learn the C++ programming language.');
        $cppPost->setContent('<p><strong>C&#43;&#43;</strong> is a powerful programming language that is used in a wide range of applications, from video games to operating systems. If you&#039;re a beginner who wants to learn C&#43;&#43;, there are a few tips and resources that can help you get started. Start with the Basics: Before diving into advanced C&#43;&#43; concepts, it&#039;s important to start with the basics. This means understanding the syntax and structure of the language, as well as the fundamental concepts such as variables, data types, functions, and control structures.</p><p>One great resource for learning the basics of C&#43;&#43; is the website cplusplus.com. This website offers a comprehensive tutorial that covers everything from basic syntax to advanced topics like templates and exceptions. Additionally, there are plenty of exercises and examples to help solidify your understanding of the concepts. Another great resource for beginners is the book &#34;C&#43;&#43; Primer&#34; by Stanley B. Lippman, Josée Lajoie, and Barbara E. Moo. This book is considered one of the best introductory texts for C&#43;&#43; and covers all the necessary topics in an organized and easy-to-understand manner. Practice, Practice, Practice: Learning a programming language like C&#43;&#43; takes practice.</p><p>While reading about the concepts and syntax is important, it&#039;s equally important to write code and experiment with different programming constructs. This will help you understand how the language works and how to apply the concepts you&#039;ve learned. One way to practice programming is to participate in coding challenges or contests. Websites like HackerRank and Codeforces offer a variety of programming challenges in C&#43;&#43; that can help you improve your coding skills and learn new concepts. Join a Community: Being part of a community of C&#43;&#43; programmers can be a valuable resource for beginners. Online forums like Reddit&#039;s r/cpp and Stack Overflow provide a platform to ask questions, share code, and get feedback from more experienced programmers.</p><p>Additionally, attending local programming meetups or joining online communities like Discord or Slack can provide opportunities to network and collaborate with other C&#43;&#43; programmers. Keep Learning: C&#43;&#43; is a complex language with many features and nuances. Even after mastering the basics, there is always more to learn. It&#039;s important to stay up-to-date with the latest developments and best practices in the language. Attending conferences, reading blogs, and following experts on social media can help you stay informed and continuously improve your skills. In conclusion, learning C&#43;&#43; can be a rewarding journey for beginners. By starting with the basics, practicing regularly, joining a community, and staying informed about the latest developments in the language, you can become a proficient C&#43;&#43; programmer. Remember, learning to program is a continuous process, and with dedication and effort, you can achieve your goals.</p>');
        $cppPost->setSlug('learning-c-tips-for-beginners');
        $cppPost->setCreatedAt(new \DateTimeImmutable('2023-03-08'));
        $cppPost->setPublishedAt(new \DateTimeImmutable('2023-03-08'));
        $cppPostCategories = [
            $this->getReference('category_0'),
            $this->getReference('category_1'),
        ];
        foreach ($cppPostCategories as $category) {
            $cppPost->addCategory($category);
        }
        $manager->persist($cppPost);

        $manager->flush();
    }
}
