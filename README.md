# adp-html-and-jquery-generator
All sites served using PHP need to output HTML. One way to output that HTML code using PHP is to compose and generate the HTML from parameters that define details of the HTML tags that developers need to develop to manage the page output.

This package provides a class to generate HTML tags and JavaScript code to call the jQuery library.

The class uses the PHP __call handler to allow the addition of any HTML tag or jQuery function library call to the current page output.

This way, the code of these classes is minimal, as they do not need to have many functions to support all HTML tags or jQuery functions.