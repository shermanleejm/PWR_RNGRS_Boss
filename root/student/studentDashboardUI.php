<?php

        ###########################################################################################
        #  STUDENT DASHBOARD UI: Student users see this upon login. 
        #
        # 2/9/2019: pls note that nothing here is working yet -Sue 
        #
        ###########################################################################################
?>

<!DOCTYPE html>
<html><div align='center'>
    <head>
        <meta charset="utf-8">
        <title>School timetable</title>
        <style>
        html {
        font-family: sans-serif;
        }
        table {
        border-collapse: collapse;
        border: 2px solid rgb(200,200,200);
        letter-spacing: 1px;
        font-size: 0.8rem;
        }
        td, th {
        border: 1px solid rgb(190,190,190);
        padding: 10px 20px;
        }
        td {
        text-align: center;
        }
        caption {
        padding: 10px;
        }
        </style>
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
        <form action='' method='$_POST'>
            <input type="submit" name='placebid' value='Place a Bid'> | 
            <input type="submit" name='dropbid' value='Drop a Bid'> |
            <input type="submit" name='dropsection' value='Drop a Section'>
        </form>
    </body>
</div>
</html>