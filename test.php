<?php
/*

Coding Test

Do all work in this single file.

Instructions
------------
1. Implement a constructor for the Author class which allows setting
the email and name for an Author.

2. Add a new property 'author' to the Article class along with a setter and getter.
Have the setter ensure that its sole argument is an Author object.

3. Implement Article's validate method based on rules in the doc block.

4. Implement the PHP built-in JsonSerializable interface on the Article class.
http://www.php.net/manual/en/class.jsonserializable.php
Only the title, body, and author name should be returned. Add any methods
to Author or Article that you need.

5. Write some procedural code (at the bottom of this file) that creates a new 
Article class, ensures that it validates, and then echoes out the Article as JSON.
Add any methods to Article that are deemed necessary.
*/



/**
 * Representation of a single author
 */
class Author {

    protected $email=null;
    protected $name=null;

    // In order to set email and name, our constructor will require two param,
    // While creating the object we will pass two parameter which will set email and name.
    function __construct($email, $name)
    {
        $this->email = $email;
        $this->name = $name;
//        echo "<br>This is Author email set: $this->email";
//        echo "<br>This is Author name set: $this->name";
    }

    public function getAuthorName(){
//        echo "Author Class Method AuthName Called:".$this->name;
        return $this->name;
    }
    public function getAuthorEmail(){
//        echo "Author Class Method AuthName Called:".$this->name;
        return $this->email;
    }
}

//$authObj = new Author("sd123@gmaillcom","smit");

/**
 *  Representation of a single article
 */
class Article  implements JsonSerializable {
    protected $title="";
    protected $body="";
    protected $status="";
    protected $author;
    protected $errors;


    /**
     * Sets the author parameter
     *
     * @param string email and name
     *
     * @return void
     */
    public function setAuthor($author){
        if($author instanceof Author) {
            $this->author = $author;
        }
    }

    public function getAuthor(){
        return $this->author;
    }
    /**
     * Gets the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Gets the body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;	
    }


    /**
     * Gets the status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * Sets the title parameter
     *
     * @param string $title The article title
     *
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    /**
     * Sets the body parameter
     *
     * @param string $body The article body
     *
     * @return void
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function getErrors(){
        return $this->errors;
    }
    /**
     * Validate the object.
     *
     * Ensure that the title, body, status, and author have been set.
     * Ensure that the title is not longer than 80 characters.
     * Ensure that the body has no HTML tags.
     * Ensure that the status is either 'Active' or 'Inactive'.
     *
     * If any assertions fail, a LogicException will be thrown with
     * appropriate messages.
     *
     * @throws LogicException
     *
     * @return void
     */
    public function validate()
    {

        // @todo implement me!
        $this->validateTitle();
        $this->validateAuthor();

        $this->validateBody();
        $this->validateStatus();

    }

    public function validateTitle()
    {
        if (!empty($this->getTitle())) {
            try {
                if (is_string($this->getTitle())) {
                    if (strlen($this->getTitle()) <= 80) {
                    } else {
                        $this->errors['title']  = "Title condition meets the requirement";
                    }
                }
            } catch (Exception $exp) {
                echo '<br>' .$exp->getMessage();
            }
        }else{
            $this->errors['title']  = "Title is empty";
        }
    }
    public function validateBody(){

        if(!empty($this->getBody())){
            try {
                strip_tags($this->getBody());
            }
            catch (Exception $exp){
                echo '<br>'.$exp->getMessage();
            }
        }
        else{
            $this->errors['body']  = "Body is empty";
        }
    }
    public function validateStatus(){
        if(empty($this->getStatus()) or !in_array($this->getStatus(), array('Active', 'Inactive'))){
            $this->errors['status']  = "Status is not valid";
        }
    }

    public function validateAuthor(){
            try {
                if($this->author instanceof Author) {
                    $email = $this->author->getAuthorEmail();
                    if((empty($email) or !filter_var($email, FILTER_VALIDATE_EMAIL))) {
                        $this->errors['author_email']  = "Author email in not valid";
                    }
                    if(empty($this->author->getAuthorName())) {
                        $this->errors['author_name']  = "Author name in not valid";
                    }
                } else {
                    $this->errors['author']  = "Author in not valid";
                }
            }
            catch (Exception $exp){
                echo '<br>'.$exp->getMessage();
            }
    }


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.

    }
}

/*
 * Working with JsonSerializable
 */

        // Variables that will hold the value from json and display
        $auth = "";
        $status="";
        $title="";
        $body="";

        $json_data = file_get_contents('test.json');
        // json_data is containg the data in array.
        // Ref: https://stackoverflow.com/questions/31218131/how-does-php-use-the-jsonserializable-interface
        // print_r($json_data);
        $jsondecodedData = json_decode($json_data, true);
        // By passing true in above, we are able to get the json in assosiative array form

//        print_r($jsondecodedData);

        // Intially pass null to validated function
//        $art->validate($title,$body,$status,$art->getAuthor());

//        Json display data is done using index.php file

        // For each loops to parse the data
/*
        foreach ($jsondecodedData['book'] as $bk){

            $title = !empty($bk['title']) ? $bk['title'] : 'Title is Empty';
            $body = !empty($bk['body']) ? $bk['body'] : 'Body is Empty';
            $status = !empty($bk['status']) ? $bk['status'] : 'Status is Empty';
            $art = new Article();

            $art->setTitle($title);
            $art->setBody($body);
            $art->setStatus($status);

            if(!empty($bk['author']['email'])) {
                $name = !empty($bk['author']['name']) ? $bk['author']['name'] : '';
                $art->setAuthor(new Author($bk['author']['email'], $name));
            }

            $art->validate();
            if(empty($art->getErrors())){
                $auth = $art->getAuthor();
                echo "<div>Title: ".$title."</div>";
                echo "<div>Author: ".$auth->getAuthorName().' ( '.$auth->getAuthorEmail()." )</div>";
                echo "<div>Status: ".$status."</div>";
                echo "<div>Body: ".$body."</span></div>";
            }else{
                foreach ($art->getErrors() as $err => $message){
                    echo "<b>".$err.' :</b>'.$message.'<br/>';
                }
            }
        }

*/
?>