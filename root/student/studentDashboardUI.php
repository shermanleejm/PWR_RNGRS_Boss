<?php

        ###########################################################################################
        #  STUDENT DASHBOARD UI: Student users see this upon login. 
        #
        # 2/9/2019: pls note that nothing here is working yet -Sue 
        #
        ###########################################################################################

        include_once('../shared/css.html')
?>

<!DOCTYPE html>
<html><div align='center'>
    <head>
        <title>School timetable</title>
    </head>

    <body>    
        <h1> Hello (name), Welcome to BOSS! </h1>

        <table>
            <tr>
                <th colspan=6>Class timetable</th>
            <tr>
            <tr>
                <td></td>
                <td>Monday</td>
                <td>Tuesday</td>
                <td>Wednesday</td>
                <td>Thurday</td>
                <td>Friday</td>
            <tr>
            <tr>
                <td>08:30-11:45</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            <tr>
            <tr>
                <td>12:00-15:15</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            <tr>
            <tr>
                <td>15:30-18:45</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            <tr>
        </table>
        <br>
        <br>
        <form action='studentDashboardUI.php' method='$_POST'>
            <input type="submit" formaction='biddingui.php' value='Manage Your Bids'> | 
            <input type="submit" name='dropsection' value='Drop a Section'>
        </form>
    </body>
</div>
</html>