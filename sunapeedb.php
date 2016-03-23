<?php session_start();?>
<?php
class SunapeeDB
{
    const HOST = "sunapee.cs.dartmouth.edu";
    const USER = "jaysha";
    const PASS = "11111111";
    const DB = "jaysha_db";
    private $con = NULL;
    
    public function connect()
    {
        $this->con = mysql_connect(self::HOST, self::USER, self::PASS);
        if (!$this->con) {
            die("SQL Error: " . mysql_error());
        }
        mysql_select_db(self::DB, $this->con);
        mysql_set_charset("utf8mb4");
    }
    
    public function get_table($table)
    {
        if ($this->con === NULL) {
            return;
        }
        
        $result = mysql_query("SELECT * FROM $table;");
        
        if (!$result) {
            die("SQL Error: " . mysql_error());
        }
        
        $this->print_table($result);
        
        mysql_free_result($result);
    }
    
    public function insert_student($id, $name, $dept, $credits)
    {
        if ($this->con === NULL) {
            return false;
        }
        
        $result = mysql_query("INSERT INTO student (ID, name, dept_name, tot_cred) VALUES (" . $id . ",\"" . $name . "\",\"" . $dept . "\"," . $credits . ");");
        
        if (!$result) {
            die("SQL Error: " . mysql_error());
        }
        
        mysql_free_result($result);
        
        return true;
    }
    
    private function print_table($result)
    {
        print("<table>\n<thead><tr>");
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
            print("<th>" . mysql_field_name($result, $i) . "</th>");
        }
        print("</tr></thead>\n");
        
        while ($row = mysql_fetch_assoc($result)) {
            print("\t<tr>\n");
            foreach ($row as $col) {
                print("\t\t<td>$col</td>\n");
            }
            print("\t</tr>\n");
        }
        print("</table>\n");
    }
    
    public function disconnect()
    {
        if ($this->con != NULL) {
            mysql_close($this->con);
        }
    }
    
    /**********************************************
    ********Functions added by Sha for HW6*********
    ***********************************************/
    public function hw6_login($email, $psw)
    {
        if ($this->con == NULL) {
            return;
        }
        $shabi = "SELECT * FROM PEOPLE WHERE PPL_EMAIL='$email' and PPL_PASSWORD='$psw'";
        $result = mysql_query($shabi);
        if (!$result) {
            die("SQL Error: " . mysql_error());
        }
        if (mysql_num_rows($result) > 0) {
            $returnVal = 1;
        } else {
            $returnVal = 0;
        }
        mysql_free_result($result);
        return $returnVal;
    }

    public function hw6_display_flight_schedule()
    {
        if ($this->con == NULL) {
            return;
        }
        //get the query result
        $result = mysql_query("SELECT FLIGHT_NO, FLIGHT.FLIGHT_CODE, ROUTE_FCITY, ROUTE_TCITY, FLIGHT_DEPART_DATE, FLIGHT_ARRIVAL_DATE 
                               FROM FLIGHT INNER JOIN ROUTE ON FLIGHT.FLIGHT_CODE=ROUTE.FLIGHT_CODE
                               WHERE FLIGHT_NO NOT IN (
                               SELECT FLIGHT_NO FROM RESERVATION WHERE RESERVATION.PPL_ID='$_SESSION[id]')");
        
        if (!$result) {
            die("SQL Error: " . mysql_errno());
        }

        // display the table with an embedded form
        print("<table><thead><tr>");
        print("<caption><h2>Flight Schedules</h2></caption><br/>");
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
            print("<th>" . mysql_field_name($result, $i) . "</th>");
        }
        print("<th>" . "BOOK" . "</th>");
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            print("\t<tr>\n");
            foreach ($row as $col) {
                print("\t\t<td>$col</td>\n");
            }
            print("<td><form action='hw6_book.php' method='get'>
                <button type='submit' name='book' value='$row[0]'>BOOK</button>
                </form></td>");
            print("\t</tr>\n");
        }
        print("</table>\n");
        print "</div>";

        // free the result
        mysql_free_result($result);

    }

    public function hw6_reserve($PPL_ID, $FLIGHT_NO)
    {
        if ($this->con == NULL) {
            return;
        }
        $shabi = "INSERT INTO RESERVATION VALUES($PPL_ID, $FLIGHT_NO)";
        $result = mysql_query($shabi);
        if (!$result) {
            print "<br><br><center><p><b>Failed: ". mysql_error() . "</b></p></center>";
        }
        else {
            print "<br><br><center><p><b> Succeeded!</b></p></center>";
        }
    }

    public function hw6_cancel($PPL_ID, $FLIGHT_NO)
    {
        if ($this->con == NULL) {
            return;
        }
        $shabi = "DELETE FROM RESERVATION WHERE PPL_ID=$PPL_ID AND FLIGHT_NO=$FLIGHT_NO";
        $result = mysql_query($shabi);
        if (!$result) {
            print "<br><br><center><p><b>Failed: ". mysql_error() . "</b></p></center>";
        }
        else {
            print "<br><br><center><p><b> Succeeded!</b></p></center>";
        }
    }

    public function hw6_display_past_flight()
    {
        if ($this->con == NULL) {
            return;
        }
        //get the query result
        $result = mysql_query("SELECT FLIGHT.FLIGHT_NO, FLIGHT.FLIGHT_CODE, ROUTE_FCITY, ROUTE_TCITY, FLIGHT_DEPART_DATE, FLIGHT_ARRIVAL_DATE 
                               FROM FLIGHT INNER JOIN RESERVATION ON FLIGHT.FLIGHT_NO=RESERVATION.FLIGHT_NO
                               INNER JOIN ROUTE ON FLIGHT.FLIGHT_CODE=ROUTE.FLIGHT_CODE
                               WHERE FLIGHT.FLIGHT_DEPART_DATE < NOW() AND RESERVATION.PPL_ID='$_SESSION[id]';");
        if (!$result) {
            die("SQL Error: " . mysql_errno());
        }

        // display the table with an embedded form
        print("<table><thead><tr>");
        print("<caption><h2>Past Flights</h2></caption><br/>");
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
            print("<th>" . mysql_field_name($result, $i) . "</th>");
        }
        print("<th>" . "CANCEL" . "</th>");
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            print("\t<tr>\n");
            foreach ($row as $col) {
                print("\t\t<td>$col</td>\n");
            }
            print("<td><form action='hw6_cancel.php' method='get'>
                <button type='submit' name='cancel' value='$row[0]'>CANCEL</button>
                </form></td>");
            print("\t</tr>\n");
        }
        print("</table>\n");
        print "</div>";
        //print("<form><input type="submit"></form>");

        // free the result
        mysql_free_result($result);
    }

    public function hw6_display_upcoming_flight()
    {
        if ($this->con == NULL) {
            return;
        }
        //get the query result
        $result = mysql_query("SELECT FLIGHT.FLIGHT_NO, FLIGHT.FLIGHT_CODE, ROUTE_FCITY, ROUTE_TCITY, FLIGHT_DEPART_DATE, FLIGHT_ARRIVAL_DATE 
                               FROM FLIGHT INNER JOIN RESERVATION ON FLIGHT.FLIGHT_NO=RESERVATION.FLIGHT_NO
                               INNER JOIN ROUTE ON FLIGHT.FLIGHT_CODE=ROUTE.FLIGHT_CODE
                               WHERE FLIGHT.FLIGHT_DEPART_DATE > NOW() AND RESERVATION.PPL_ID='$_SESSION[id]';");
        if (!$result) {
            die("SQL Error: " . mysql_errno());
        }

        // display the table with an embedded form
        print("<table><thead><tr>");
        print("<caption><h2>Upcoming Flights</h2></caption><br/>");
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
            print("<th>" . mysql_field_name($result, $i) . "</th>");
        }
        print("<th>" . "CANCEL" . "</th>");
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            print("\t<tr>\n");
            foreach ($row as $col) {
                print("\t\t<td>$col</td>\n");
            }
            print("<td><form action='hw6_cancel.php' method='get'>
                <button type='submit' name='cancel' value='$row[0]'>CANCEL</button>
                </form></td>");
            print("\t</tr>\n");
        }
        print("</table>\n");
        print "</div>";
        //print("<form><input type="submit"></form>");

        // free the result
        mysql_free_result($result);
    }

    public function get_my_id($email)
    {
        if ($this->con == NULL) {
            return;
        }

        $result = mysql_query("SELECT PPL_ID FROM PEOPLE WHERE PEOPLE.PPL_EMAIL='$email';");

        if (!$result) {
            die("SQL Error: " . mysql_errno());
        }

        $row = mysql_fetch_array($result, MYSQL_NUM);

        return $row[0];

    }

    public function is_emp($PPL_ID)
    {
        if ($this->con == NULL) {
            return;
        }

        $result = mysql_query("SELECT PPL_ISEMP FROM PEOPLE WHERE PEOPLE.PPL_ID=$PPL_ID");

        if (!$result) {
            die("SQL Error: " . mysql_errno());
        }

        $row = mysql_fetch_array($result, MYSQL_NUM);

        return $row[0];

    }

    public function hw6_retrieve_passenger_list()
    {
        if ($this->con == NULL) {
            return;
        }
        //get the query result
        $result = mysql_query("SELECT FLIGHT_NO, FLIGHT.FLIGHT_CODE, ROUTE_FCITY, ROUTE_TCITY, FLIGHT_DEPART_DATE, FLIGHT_ARRIVAL_DATE FROM FLIGHT INNER JOIN ROUTE ON FLIGHT.FLIGHT_CODE=ROUTE.FLIGHT_CODE;");
        if (!$result) {
            die("SQL Error: " . mysql_errno());
        }

        // display the table with an embedded form
        print("<table><thead><tr>");
        print("<caption><h2>Flight Schedules</h2></caption><br/>");
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
            print("<th>" . mysql_field_name($result, $i) . "</th>");
        }
        print("<th>" . "RETRIEVE" . "</th>");
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            print("\t<tr>\n");
            foreach ($row as $col) {
                print("\t\t<td>$col</td>\n");
            }
            print("<td><form action='hw6_retrieve.php' method='get'>
                <button type='submit' name='retrieve' value='$row[0]'>RETRIEVE</button>
                </form></td>");
            print("\t</tr>\n");
        }
        print("</table>\n");
        print "</div>";

        // free the result
        mysql_free_result($result);
    }

    public function hw6_show_passenger_list($FLIGHT_NO)
    {
        if ($this->con == NULL) {
            return;
        }

        //get the query result
        $shabi = "SELECT PEOPLE.PPL_ID, PPL_FNAME, PPL_LNAME, FLIGHT_NO
                  FROM PEOPLE, RESERVATION
                  WHERE PEOPLE.PPL_ID=RESERVATION.PPL_ID AND RESERVATION.FLIGHT_NO=$FLIGHT_NO";
        $result = mysql_query($shabi);
        if(!$result) {
            die("SQL Error: " . mysql_errno());
        }
        
        // display the table with an embedded form
        print("<table><thead><tr>");
        print("<caption><h2>Passenger List</h2></caption><br/>");
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
            print("<th>" . mysql_field_name($result, $i) . "</th>");
        }
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            print("\t<tr>\n");
            foreach ($row as $col) {
                print("\t\t<td>$col</td>\n");
            }
            print("\t</tr>\n");
        }
        print("</table>\n");
        print "</div>";

        mysql_free_result($result);
    }

    public function hw6_handle_most_booked_flights($fromDate, $toDate)
    {
        if ($this->con == NULL) {
            return;
        }

        //get the query result
        $shabi = "SELECT FLIGHT.FLIGHT_NO, COUNT(*) AS NUM FROM RESERVATION, FLIGHT
                  WHERE RESERVATION.FLIGHT_NO = FLIGHT.FLIGHT_NO AND FLIGHT.FLIGHT_DEPART_DATE > '$fromDate' AND FLIGHT.FLIGHT_DEPART_DATE < '$toDate'
                  GROUP BY FLIGHT.FLIGHT_NO ORDER BY NUM DESC
                  LIMIT 5";
        $result = mysql_query($shabi);
        if (!result) {
            die("SQL Error: " . mysql_errno());
        }

        // display the table with an embedded form
        print("<center><caption><h2>Most Booked Flights</h2></caption><br/></center>");
        print("<table><thead><tr>");
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
            print("<th>" . mysql_field_name($result, $i) . "</th>");
        }
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            print("\t<tr>\n");
            foreach ($row as $col) {
                print("\t\t<td>$col</td>\n");
            }
            print("\t</tr>\n");
        }
        print("</table>\n");
        print "</div>";

        mysql_free_result($result); 

    }

}
?>