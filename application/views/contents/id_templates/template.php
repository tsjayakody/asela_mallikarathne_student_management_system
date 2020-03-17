<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<body>
    <style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Titillium+Web&display=swap');

    .qrcrop {
        position: absolute;
        width: 57px;
        height: 57px;
        overflow: hidden;
        margin-top: -2.27in;
        margin-left: 1.358in;
    }

    img.qrimg {
        position: relative;
        top: -15px;
        left: -15px;
        width: 87px;
        height: 87px;
    }

    img.student_face {
        width: 1.17in;
        position: absolute;
        margin-top: 1.01in;
        margin-left: 0.14in;
    }

    h3.class_year {
        position: absolute;
        font-size: 13px;
        margin-top: .75in;
        margin-left: .65in;
        width: 1.3in;
        font-family: 'Titillium Web', sans-serif;
    }

    h3.student_name {
        position: absolute;
        font-size: 11px;
        font-family: 'Titillium Web', sans-serif;
        /*margin-top: 2.25in;*/
        margin-left: 0.55in;
        width: 1.45in;
    }

    </style>
    <?php
            if (isset($student)) {
                $column_count = 0;
                $row_count = $student->num_rows();
                $html = '<table cellpadding="1" cellspacing="1">';
                foreach ($student->result_array() as $key => $value) {
                    if ($column_count == 0) {
                        $html.= '<tr>';
                    }
                    $html.= '
                    <td>
                      <div  style="height:3.5in;width:2.1in;">
                            <img class="background_image" style="height:3.5in;width:2.1in;" src="'.base_url().'assets/id_backgrounds/'.$value['background_image'].'">
                            <h3 class="class_year" style="margin-top: -2.78in;z-index: 500">'.$value['year'].' '.$value['types'].'</h3>
                            <h3  style="position:absolute;;  margin-top: -1.3in;z-index: 1000" class="student_name">'.$value['first_name'].' '.$value['last_name'].'<br/>'.$value['student_id'].'<br/>'.$value['locations'].'</h3>
                            <img src="'.base_url().$value['student_image'].'"  style=" width: 1.17in; position: absolute; margin-top: -2.53in; margin-left: 0.14in;z-index: 500;"/>
                            <div class="qrcrop">
                                <img class="qrimg" src="https://chart.googleapis.com/chart?chs=75x75&cht=qr&chl='.$value['student_id'].'" />
                            </div>   
                        </div>
                     </td>                        

                    <!--<td>
                        <div class="qrcrop">
                        <img class="qrimg" src="https://chart.googleapis.com/chart?chs=75x75&cht=qr&chl='.$value['student_id'].'" />
                        </div>
                        <h3 class="class_year">'.$value['year'].' '.$value['types'].'</h3>
                        <img src="'.base_url().$value['student_image'].'" class="student_face" style=" width: 1.17in; position: absolute; margin-top: 1.01in; margin-left: 0.14in;"/>
                        <h3 class="student_name">'.$value['first_name'].' '.$value['last_name'].'<br/>'.$value['student_id'].'<br/>'.$value['locations'].'</h3>
                        <img class="background_image" style="height:3.5in;width:2.1in;" src="'.base_url().'assets/id_backgrounds/'.$value['background_image'].'">
                    </td>-->
                        ';
                    
                    if ($column_count == 4 || $row_count == 1) {
                        $html.= '</tr>';
                        $column_count = 0;
                    } else {
                        $column_count++;
                    }
                    
                }
                $html .= '</table>';
                echo $html;
            }
        ?>
</body>

</html>