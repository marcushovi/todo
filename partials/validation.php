<?php

/**
 *  Validation
 */
class validate
{

    const KiB = 1024;
    private $maxLengthOfName;
    private $minLengthOfName;
    private $minLengthOfPass;
    private $maxLengthOfEmail;
    private $maxLengthOfTitle;
    private $maxLengthOfDescription;
    private $maxLengthOfPriority;
    private $maxSizeOfFileKB;
    private $maxLengthOfFileName;
    private $allowedFileExtensions;

    /**
     * validate constructor.
     * @param $maxLengthOfName
     * @param $minLengthOfName
     * @param $minLengthOfPass
     * @param $maxLengthOfEmail
     * @param $maxLengthOfTitle
     * @param $maxLengthOfDescription
     * @param $maxLengthOfPriority
     * @param $maxSizeOfFileKB
     * @param $maxLengthOfFileName
     * @param $allowedFileExtensions
     */
    public function __construct( $maxLengthOfName, $minLengthOfName, $minLengthOfPass, $maxLengthOfEmail, $maxLengthOfTitle, $maxLengthOfDescription, $maxLengthOfPriority, $maxSizeOfFileKB, $maxLengthOfFileName, $allowedFileExtensions )
    {
        $this->maxLengthOfName = $maxLengthOfName;
        $this->minLengthOfName = $minLengthOfName;
        $this->minLengthOfPass = $minLengthOfPass;
        $this->maxLengthOfEmail = $maxLengthOfEmail;

        $this->maxLengthOfTitle = $maxLengthOfTitle;
        $this->maxLengthOfDescription = $maxLengthOfDescription;
        $this->maxLengthOfPriority = $maxLengthOfPriority;

        $this->maxSizeOfFileKB = $maxSizeOfFileKB;
        $this->maxLengthOfFileName = $maxLengthOfFileName;
        $this->allowedFileExtensions = $allowedFileExtensions;
    }


    public function validateName( $value )
    {

        // required
        if ( $value == "" ) {
            return "<span class=\"war\">Required</span>";
        }

        // length min 3 and max 200 char.,
        if ( strlen( trim( $value ) ) < $this->minLengthOfName ) {
            return "<span class=\"war\">Must contain at least $this->minLengthOfName letters</span>";
        }
        if ( strlen( trim( $value ) ) > $this->maxLengthOfName ) {
            return "<span class=\"war\">Must contain no more than $this->maxLengthOfName letters</span>";
        }

        // must contain characters from english alphabet only
        if ( !ctype_alpha( $value ) ) {
            return "<span class=\"war\">Must contain only letters (only english alphabet)</span>";
        }


        return true;
    }

    public function validateEmail( $value )
    {

        // required
        if ( $value == "" ) {
            return "<span class=\"war\">Required</span>";
        }

        // length min 6 and max 400 char
        if ( strlen( trim( $value ) ) > $this->maxLengthOfEmail ) {
            return "<span class=\"war\">Must contain no more than $this->maxLengthOfEmail letters</span>";
        }
        if ( strlen( trim( $value ) ) < 6 ) {
            return "<span class=\"war\">Must contain least 6 letters</span>";
        }

        // must contain @ and .
        if ( strpos( $value, "@" ) === false ) {
            return "<span class=\"war\">Must contain '@'</span>";
        }
        if ( strpos( $value, "." ) === false ) {
            return "<span class=\"war\">Must contain '.'</span>";
        }

        return true;
    }

    public function validatePassword( $value1, $value2 )
    {

        // required
        if ( $value1 == "" ) {
            return "<span class=\"war\">Required</span>";
        }

        // length min 8 , must equals
        if ( strlen( $value1 ) < $this->minLengthOfPass ) {
            return "<span class=\"war\">Must contain at least $this->minLengthOfPass characters</span>";
        }

        // must equals
        if ( $value2 != $value1 ) {
            return "<span class=\"war\">Must equals</span>";
        }

        return true;
    }

    public function validateFile( $extension )
    {
        // check size
        if ( $_FILES[ "file" ][ "size" ] > $this->maxSizeOfFileKB * self::KiB ) {
            return "<span class=\"red-span\">File is too big (max size of file is " . $this->maxSizeOfFileKB . " KiB).</span>";
        }

        // check extension
        $valid = false;

        foreach ( $this->allowedFileExtensions as $i ) {
            if ( $extension === $i )
                $valid = true;
        }
        if ( $valid === false ) {
            $re = "<span class=\"red-span\">Sorry, only ";

            foreach ( $this->allowedFileExtensions as $i ) {
                $re .= $i . ", ";
            }

            $re .= " are allowed.</span>";

            return $re;
        }

        // check length of name
        if ( strlen( $_FILES[ "file" ][ "name" ] ) > $this->maxLengthOfFileName ) {
            return "<span class=\"red-span\">Name of file this too long.</span>";
        }
        return true;

    }

    public function validateTask()
    {
        // check length of title
        if ( strlen( $_POST[ "title" ] ) > $this->maxLengthOfTitle ) {
            return "<span class=\"red-span\">Title is too long.</span>";
        }

        // check length of description
        if ( strlen( $_POST[ "description" ] ) > $this->maxLengthOfDescription ) {
            return "<span class=\"red-span\">Description is too long.</span>";
        }

        // check length of priority
        if ( strlen( $_POST[ "priority" ] ) > $this->maxLengthOfPriority ) {
            return "<span class=\"red-span\">Priority is too long.</span>";
        }

        return true;
    }
}

?>