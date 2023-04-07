<?php

namespace App\DataFixtures;

use App\Entity\Post;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $pyJsPost = new Post();
        $pyJsPost->setTitle('Python vs. JavaScript');
        $pyJsPost->setDescription('A comparison of two popular programming languages, Python and JavaScript, and their strengths and weaknesses for various types of projects.');
        $pyJsPost->setContent('<p style="text-align:center"><img alt="Python vs JavaScript" height="477" src="https://www.simplilearn.com/ice9/free_resources_article_thumb/python_vs_javascript.jpg" width="848" /></p><p>&nbsp;</p><p><strong>Python </strong>and <strong>JavaScript </strong>are two of the most popular programming languages used today. Both have their strengths and weaknesses, and choosing the right language for your project can be a difficult decision. In this article, we&#39;ll compare Python and JavaScript in various aspects to help you decide which language to choose for your next project.</p><h2>Application Domain</h2><p>Python is a general-purpose language that is widely used in scientific computing, data analysis, machine learning, and artificial intelligence applications. It is also used for web development, game development, desktop application development, and system scripting. JavaScript, on the other hand, is mainly used for web development, including front-end and back-end development, and increasingly used for server-side applications.</p><h2>Syntax</h2><p>Python has a simple and easy-to-learn syntax, making it ideal for beginners. It uses indentation to define code blocks, making the code more readable. JavaScript syntax is similar to C and C++, making it slightly more difficult to learn than Python. JavaScript also has more complex syntax for defining functions and object-oriented programming.</p><h2>Performance</h2><p>Python is an interpreted language, which means that it is slower than compiled languages such as C++ and Java. However, Python has many libraries and frameworks that can improve its performance for specific applications. JavaScript is also an interpreted language, but it is designed to run in web browsers, which limits its performance. However, JavaScript can be optimized for performance through techniques such as code minification, bundling, and just-in-time (JIT) compilation. JIT compilation involves compiling code at runtime, which can significantly improve performance. Python&#39;s performance can also be improved by using tools such as PyPy, which is an alternative interpreter that can provide a speed boost for certain applications.</p><p>Additionally, Python has libraries such as NumPy and SciPy that are optimized for numerical calculations and scientific computing, making them ideal for data analysis and machine learning applications. JavaScript&#39;s performance can be further improved by using modern frameworks such as React and Vue.js, which use virtual DOM and other techniques to optimize rendering speed. Node.js, a popular JavaScript runtime environment, also allows developers to build high-performance server-side applications. In terms of raw performance, C++ and Java are generally faster than both Python and JavaScript. However, the performance differences may not be significant for many applications, and the ease of development and availability of libraries and frameworks in Python and JavaScript may outweigh any performance benefits of using a compiled language.</p><h2>Conclusion</h2><p>Ultimately, the choice between Python and JavaScript will depend on the specific requirements of your project. If you are working on a data analysis or machine learning application, or if you need to build a complex desktop application, Python may be the better choice. If you are developing a web application or server-side application, JavaScript may be the more suitable language. However, both languages are versatile and can be used for a wide range of applications, so it&#39;s worth considering both options before making a decision.</p>');
        $pyJsPost->setSlug($this->slugger->slug($pyJsPost->getTitle())->lower());
        $pyJsPost->setCreatedAt(new DateTimeImmutable('2023-03-08'));
        $pyJsPost->setPublishedAt(new DateTimeImmutable('2023-03-08'));
        $pythonJavascriptPostCategories = [
            $this->getReference('category_languages'),
            $this->getReference('category_web'),
        ];
        foreach ($pythonJavascriptPostCategories as $category) {
            $pyJsPost->addCategory($category);
        }
        $this->addReference('post_pyjs', $pyJsPost);
        $manager->persist($pyJsPost);

        $cppPost = new Post();
        $cppPost->setTitle('Learning C++: Tips for Beginners');
        $cppPost->setDescription('A list of tips and resources for beginners who want to learn the C++ programming language.');
        $cppPost->setContent('<p style="text-align:center"><img alt="C++ basics" height="470" src="https://media.geeksforgeeks.org/wp-content/cdn-uploads/20230304231205/C-Language2.png" width="1000" /></p><p>&nbsp;</p><p><strong>C++</strong> is a powerful programming language that is used in a wide range of applications, from video games to operating systems. If you&#39;re a beginner who wants to learn C++, there are a few tips and resources that can help you get started. Start with the Basics: Before diving into advanced C++ concepts, it&#39;s important to start with the basics. This means understanding the syntax and structure of the language, as well as the fundamental concepts such as variables, data types, functions, and control structures.</p><p>One great resource for learning the basics of C++ is the website cplusplus.com. This website offers a comprehensive tutorial that covers everything from basic syntax to advanced topics like templates and exceptions. Additionally, there are plenty of exercises and examples to help solidify your understanding of the concepts. Another great resource for beginners is the book &quot;C++ Primer&quot; by Stanley B. Lippman, Jos&eacute;e Lajoie, and Barbara E. Moo. This book is considered one of the best introductory texts for C++ and covers all the necessary topics in an organized and easy-to-understand manner. Practice, Practice, Practice: Learning a programming language like C++ takes practice.</p><p>While reading about the concepts and syntax is important, it&#39;s equally important to write code and experiment with different programming constructs. This will help you understand how the language works and how to apply the concepts you&#39;ve learned. One way to practice programming is to participate in coding challenges or contests. Websites like HackerRank and Codeforces offer a variety of programming challenges in C++ that can help you improve your coding skills and learn new concepts. Join a Community: Being part of a community of C++ programmers can be a valuable resource for beginners. Online forums like Reddit&#39;s r/cpp and Stack Overflow provide a platform to ask questions, share code, and get feedback from more experienced programmers.</p><p>Additionally, attending local programming meetups or joining online communities like Discord or Slack can provide opportunities to network and collaborate with other C++ programmers. Keep Learning: C++ is a complex language with many features and nuances. Even after mastering the basics, there is always more to learn. It&#39;s important to stay up-to-date with the latest developments and best practices in the language. Attending conferences, reading blogs, and following experts on social media can help you stay informed and continuously improve your skills. In conclusion, learning C++ can be a rewarding journey for beginners. By starting with the basics, practicing regularly, joining a community, and staying informed about the latest developments in the language, you can become a proficient C++ programmer. Remember, learning to program is a continuous process, and with dedication and effort, you can achieve your goals.</p>');
        $cppPost->setSlug($this->slugger->slug($cppPost->getTitle())->lower());
        $cppPost->setCreatedAt(new DateTimeImmutable('2023-03-13'));
        $cppPost->setPublishedAt(new DateTimeImmutable('2023-03-13'));
        $cppPostCategories = [
            $this->getReference('category_languages'),
            $this->getReference('category_web'),
            $this->getReference('category_snippets'),
        ];
        foreach ($cppPostCategories as $category) {
            $cppPost->addCategory($category);
        }
        $this->addReference('post_cpp', $cppPost);
        $manager->persist($cppPost);

        $aiPost = new Post();
        $aiPost->setTitle('AI and Career: Opportunities and Challenges');
        $aiPost->setDescription("A closer look at the world of AI and the various career paths available in this rapidly evolving field. We'll discuss the current state of AI, the skills and knowledge required for a career in AI, and the challenges facing the industry, including ethical concerns and the impact of automation on jobs.");
        $aiPost->setContent('<p style="text-align:center"><img alt="Artificial Intelligence" height="424" src="https://futureofwork.georgetown.edu/wp-content/uploads/sites/335/2021/10/Artificial-Intellegence-e1634237254116.jpeg" width="1170" /></p><p>&nbsp;</p><p>Artificial intelligence (AI) has rapidly become one of the most exciting and rapidly growing fields of study and application across a range of industries. With its potential to automate processes, reduce errors and optimize decision-making, AI is a game-changer for businesses looking to gain a competitive edge in their industries. However, the field of AI is still relatively new, and it can be difficult to navigate the various career paths available in this rapidly evolving field.</p><p>In this blog post, we&#39;ll explore some of the main categories of AI and the different career paths available in each one.</p><h3>Machine Learning</h3><p>Machine learning (ML) is one of the most popular subfields of AI, which focuses on developing algorithms that can learn from data without being explicitly programmed. In essence, machine learning models can analyze vast amounts of data and automatically identify patterns and relationships, which can be used to make predictions or classify new data.</p><p>Careers in machine learning include:</p><ul><li>Machine Learning Engineer: responsible for designing and building ML systems that can learn from data, making predictions or classifications.</li><li>Data Scientist: use machine learning and other statistical techniques to analyze data and derive insights.</li><li>AI Researcher: work on developing new machine learning algorithms and models.</li></ul><h3>Natural Language Processing (NLP)</h3><p>NLP is another important subfield of AI that focuses on enabling machines to understand and process human language. This can be achieved through techniques such as sentiment analysis, speech recognition, and machine translation.</p><p>Careers in NLP include:</p><ul><li>NLP Engineer: responsible for designing and developing NLP systems that can understand and process human language.</li><li>Conversational AI Designer: design and develop conversational interfaces that can interact with users in a natural way.</li><li>Computational Linguist: work on developing algorithms and models that can understand the structure and meaning of language.</li></ul><h3>AI Ethics</h3><p>As AI becomes more prevalent in our daily lives, concerns about the ethical implications of this technology have also grown. AI ethics is a subfield of AI that focuses on ensuring that the development and use of AI is ethical and socially responsible.</p><p>Careers in AI ethics include:</p><ul><li>AI Ethics Researcher: conduct research into the ethical implications of AI and develop guidelines for responsible AI development and use.</li><li>AI Policy Analyst: work on developing policies and regulations that ensure that AI is developed and used in an ethical and socially responsible manner.</li><li>AI Ethics Officer: responsible for ensuring that AI systems developed by their organization are ethical and comply with relevant regulations and guidelines.</li></ul><h3>Conclusion</h3><p>In conclusion, AI is a rapidly growing field with many exciting career opportunities. Whether you&#39;re interested in machine learning, natural language processing, computer vision, or another area of AI, there are many paths you can take to build a successful career. However, as AI continues to advance, there are also important ethical considerations to keep in mind, such as the potential for bias and the impact of automation on jobs. By staying up-to-date with the latest developments in AI and continually building your skills and knowledge, you can position yourself for a rewarding career in this dynamic field.</p>');
        $aiPost->setSlug($this->slugger->slug($aiPost->getTitle())->lower());
        $aiPost->setCreatedAt(new DateTimeImmutable('2023-03-18'));
        $aiPost->setPublishedAt(new DateTimeImmutable('2023-03-18'));
        $aiPostCategories = [
            $this->getReference('category_ai'),
            $this->getReference('category_career'),
        ];
        foreach ($aiPostCategories as $category) {
            $aiPost->addCategory($category);
        }
        $this->addReference('post_ai', $aiPost);
        $manager->persist($aiPost);

        $devopsPost = new Post();
        $devopsPost->setTitle('The Intersection of DevOps and Cloud');
        $devopsPost->setDescription("In recent years, the rise of cloud computing has transformed the IT industry, and DevOps has emerged as a critical methodology for modern software development. The intersection of DevOps and cloud computing has become a vital aspect of software development, with organizations worldwide adopting the two to improve their delivery capabilities, agility, and scalability.");
        $devopsPost->setContent('<p style="text-align:center"><img alt="DevOps cycle and tools" height="669" src="https://shalb.com/wp-content/uploads/2019/11/Devops1-1024x669.jpeg" width="1024" /></p><h3>&nbsp;</h3><h3>Introduction</h3><p>DevOps emerged as a methodology to break down silos between development and operations teams and accelerate the software delivery process. Cloud computing allows organizations to access computing resources over the internet, leading to increased scalability, cost savings, and flexibility.</p><h3>DevOps and Cloud Computing</h3><p>The combination of DevOps and cloud computing is powerful, as cloud computing provides the infrastructure and tools necessary for implementing DevOps practices effectively.</p><h3>Benefits and Challenges of DevOps and Cloud Computing</h3><p>DevOps and cloud computing provide organizations with increased agility, scalability, cost savings, and flexibility. However, challenges and risks of DevOps and cloud computing include security, compliance, and vendor lock-in.</p><h3>Best Practices and Tools for Implementing DevOps in the Cloud</h3><p>Best practices for implementing DevOps in a cloud computing environment include automation, continuous integration and delivery, and infrastructure as code. Popular tools for DevOps and cloud computing include automation tools, containerization tools, and configuration management tools.</p><h3>Conclusion</h3><p>The intersection of DevOps and cloud computing has become a critical aspect of modern software development. By adopting DevOps practices in a cloud computing environment, organizations can achieve greater agility, scalability, and efficiency, ultimately delivering better products and services to their customers. It&#39;s important to address the challenges and risks of this intersection, but the benefits outweigh the risks when implemented correctly.</p>');
        $devopsPost->setSlug($this->slugger->slug($devopsPost->getTitle())->lower());
        $devopsPost->setCreatedAt(new DateTimeImmutable('2023-03-24'));
        $devopsPost->setPublishedAt(new DateTimeImmutable('2023-03-24'));
        $devopsPostCategories = [
            $this->getReference('category_devops'),
            $this->getReference('category_cloud'),
        ];
        foreach ($devopsPostCategories as $category) {
            $devopsPost->addCategory($category);
        }
        $this->addReference('post_devops', $devopsPost);
        $manager->persist($devopsPost);

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            CategoryFixtures::class,
        ];
    }
}
