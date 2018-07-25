<?php
    require_once('password.php');
    $link = mysql_connect($db_host,$db_user,$db_pass);
    mysql_select_db($db_database);
?>

<!doctype html>
<html>
    <head>
        <title>Home | Stuart Roskelley</title>
        
        <link rel="icon" type="image/png" href="img/favicon.ico">
        <link href='http://fonts.googleapis.com/css?family=Syncopate|Orbitron:700' rel='stylesheet' type='text/css'>
        <link href="css/hover.css" id="main-stylesheet" rel="stylesheet" type="text/css">
        <link href="lib/shadowbox-3.0.3/shadowbox.css" rel="stylesheet" type="text/css">
        <script src="lib/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="lib/shadowbox-3.0.3/shadowbox.js" type="text/javascript"></script>
        <script src="js/hover.js" type="text/javascript"></script>
        <script type="text/javascript">            
            respSSCheck(); // check for mobile or incompatible size
            $(document).ready(function(){
                window.resume = new Resume();
                $(window).resize(respSSCheck);
            });
            
            Shadowbox.init({
                modal:true,
                overlayOpacity:0.85
            });
        </script>
        <?php include_once('tags.php'); ?>
    </head>
    <body>
        <div id="top-nav-cont">
            <div class="shadow"></div>
            <div class="main">
                <div class="name">Stuart Roskelley</div>
                <div class="address">
                    435-535-1051<br>
                    <a href="mailto:me@stuartrosk.com">me@stuartrosk.com</a>
                </div>
                <div class="links">
                    <ul>
                        <li>
                            <div class="social-logo">
                                <a href="http://stackoverflow.com/story/sroskelley">
                                    <img src="./img/stackoverflow.png" />
                                </a>
                            </div>
                            <div class="social-logo">
                                <a href="https://plus.google.com/+StuartRoskelley/about">
                                    <img src="./img/gplus.png" />
                                </a>
                            </div>
                            <div class="social-logo">
                                <a href="http://www.linkedin.com/in/sroskelley/">
                                    <img src="./img/linkedin.png" />
                                </a>
                            </div>
                        </li>
                        <a href="about.php"><li>About Me</li></a>
                        <a href="http://blog.stuartrosk.com"><li>Blog</li></a>
                        <!--<a href="tubby_tap"><li>Tubby Tap</li></a>-->
                    </ul>
                </div>
                <div class="menu"></div>
            </div>
        </div>
        <div class="fixed-wrapper"> <!-- used transform: translateX(####px) -->
            <div id="name-main-cont" class="animated-breathe">
                <div class="left-col">
                    <div class="name">
                        Stuart Roskelley
                    </div>
                    <div class="address">
                        <div>
                            435-535-1051<br>
                            <a href="mailto:me@stuartrosk.com">me@stuartrosk.com</a>
                        </div>
                    </div>
                </div>
                <div class="right-col">
                    <ul class="link-list">
                        <script type="text/javascript">
                            document.write($("div.links ul").html());
                        </script>
                    </ul>
                </div>
            </div>
            
            <div id="resume-box">
                <div class="title">Resume</div>
                <div class="down-arrow"></div>
                <div class="text">Scroll down or click arrow.</div>
            </div>
            
            <a href="clients.php">
                <div class="main-sub-box box1">
                    <div class="image"></div>
                    <div class="title">Clients</div>
                    <div class="text">Clients worked with for various projects including websites, tag management, and analytics.</div>
                </div>
            </a>
            
            <a href="code.php">
                <div class="main-sub-box box2">
                    <div class="image"></div>
                    <div class="title">Coding Projects</div>
                    <div class="text">Various code projects for use in practice and learning for all.</div>
                </div>
            </a>
            
            <a href="projects.php">
                <div class="main-sub-box box3">
                    <div class="image"></div>
                    <div class="title">Other Projects</div>
                    <div class="text">Various projects I'm currently working on or have done outside of coding or websites.</div>
                </div>
            </a>
            
            <?php
                $sql = '
                    SELECT
                        s.id,
                        s.section_title,
                        COUNT(sl.id) AS num
                    FROM resume_section AS s
                    LEFT JOIN resume_skill_list AS sl ON s.id = sl.section_id
                    GROUP BY s.id
                    ORDER BY s.order ASC
                ';
                $section_result = mysql_query($sql) or die(mysql_error());
                while($section = mysql_fetch_array($section_result)) {
                    echo '<h1 id="title'.$section['id'].'" class="section-title">'.$section['section_title'].'</h1>';
                    if ($section['num'] == 0) {
                        echo '<div id="section'.$section['id'].'" class="section type1">';
                        echo '<div class="disable-cover"></div>
                              <div class="header"><span class="text">Newer</span></div>
                              <div class="content">';
                        $sql = '
                            SELECT
                                si.id,
                                si.title,
                                si.company,
                                si.dates,
                                si.small_desc,
                                COUNT(im.id) AS num
                            FROM resume_section_item AS si
                            LEFT JOIN resume_list AS im ON im.item_id = si.id
                            WHERE si.section_id = "'.$section['id'].'"
                            GROUP BY si.title, si.company
                            ORDER BY si.order DESC
                        ';
                        $lb_result = mysql_query($sql) or die(mysql_error());
                        while($lb = mysql_fetch_array($lb_result)) {
                            echo '
                                <div class="link-block ';
                            if ($lb['num'] > 0) echo 'expand';    
                            echo '" itemnum="'.$lb['id'].'">
                                    <div class="title">
                                        <h2 class="name">'.$lb['title'].'
                                            <div class="sub-name">'.$lb['company'].'</div>
                                        </h2>
                                        <div class="name-info">'.$lb['dates'].'</div>
                                    </div>
                                    '.$lb['small_desc'].'
                                </div>
                            ';
                        }
                        echo '
                                </div>
                                <div class="footer"><span class="text">Older</span></div>
                            </div>
                        ';
                    } else {
                        echo '
                            <div id="section'.$section['id'].'" class="section type2">
                                <div class="left-col">
                                    <div class="header">Computer</div>
                                    <div class="content">';
                                        $sql = "SELECT skill FROM resume_skill_list WHERE type = 'Computer' ORDER BY skill";
                                        $skill_result = mysql_query($sql) or die(mysql_error());
                                        $skill_str = '';
                                        while($skill=mysql_fetch_array($skill_result)) { $skill_str .= $skill['skill'].', '; }
                                        echo substr($skill_str, 0, -2);
                        echo '      </div>
                                </div>
                                <div class="right-col">
                                    <div class="header">Everything Else</div>
                                    <div class="content">';
                                        $sql = "SELECT skill FROM resume_skill_list WHERE type = 'Everything Else' ORDER BY skill";
                                        $skill_result = mysql_query($sql) or die(mysql_error());
                                        $skill_str = '';
                                        while($skill=mysql_fetch_array($skill_result)) { $skill_str .= $skill['skill'].', '; }
                                        echo substr($skill_str, 0, -2);
                        echo '      </div>
                                </div>
                            </div>
                        ';
                    }
                }
            ?>
            
        </div>
        
        <?php 
            mysql_data_seek($section_result, 0);
            while($section = mysql_fetch_array($section_result)) {
                $sql = '
                    SELECT
                        si.id,
                        si.title,
                        si.company,
                        si.dates,
                        si.large_desc,
                        COUNT(im.id) AS list_num,
                        COUNT(l.id) AS sub_num,
                        im.list_title,
                        im.id AS p_id
                    FROM resume_section_item AS si
                    LEFT JOIN resume_list AS im ON im.item_id = si.id
                    LEFT JOIN resume_list AS l ON im.id = l.parent_list_id
                    WHERE si.section_id = "'.$section['id'].'"
                    GROUP BY si.title, si.company
                    ORDER BY si.order DESC
                ';
                $item_result = mysql_query($sql) or die(mysql_error());
                while($item = mysql_fetch_array($item_result)) {
                    if ($item['list_num'] > 0 && $item['sub_num'] == 0) {
                        echo '
                            <div id="section'.$section['id'].'_'.$item['id'].'-detail" class="detail type3">
                                <div class="header">
                                    <div class="back-button"></div>
                                    <div class="title">
                                        '.$item['title'].'
                                    </div>
                                    <div class="sub-title">
                                        '.$item['company'].'<br>
                                        '.$item['dates'].'
                                    </div>
                                </div>
                                <div class="left-col">
                                    <div class="content">
                                        '.$item['large_desc'].'
                                    </div>
                                </div>
                                <div class="right-col">
                                    <ul class="images">
                        ';
                        $sql = '
                            SELECT
                                i.image_name,
                                i.thumb_name,
                                i.image_desc
                            FROM resume_list AS l
                            LEFT JOIN resume_image AS i ON l.id = i.list_id
                            WHERE l.item_id = "'.$item['id'].'"
                        ';
                        $img_result = mysql_query($sql) or die(mysql_error());
                        while($img = mysql_fetch_array($img_result)) {
                            echo '<li><a href="img/screenshots/'.$img['image_name'].'" rel="shadowbox[section'.$section['id'].'_'.$item['id'].'];width=770;height=467" title="'.$img['image_desc'].'"><img src="img/screenshots/'.$img['thumb_name'].'" width="215px" height="130px" /></a></li>';
                        }
                        echo '      </ul>
                                </div>
                            </div>
                        ';
                    }
                    if ($item['sub_num'] > 0) {
                        echo '
                            <div id="section'.$section['id'].'_'.$item['id'].'-detail" class="detail type3">
                                <div class="header">
                                    <div class="back-button"></div>
                                    <div class="title">
                                        '.$item['title'].'
                                    </div>
                                    <div class="sub-title">
                                        '.$item['company'].'<br>
                                        '.$item['dates'].'
                                    </div>
                                    <div class="list-header">
                                        '.$item['list_title'].'
                                    </div>
                                </div>
                                <div class="left-col">
                                    <div class="content">
                                        '.$item['large_desc'].'
                                    </div>
                                </div>
                                <div class="right-col">
                                    <ul class="link-list">
                        ';
                        $sql = '
                            SELECT
                                l.id,
                                l.list_title
                            FROM resume_list AS l
                            WHERE l.parent_list_id = "'.$item['p_id'].'"
                        ';
                        $sl_result = mysql_query($sql) or die(mysql_error());
                        while($sl = mysql_fetch_array($sl_result)) {
                            $pic_names = "";
                            $pic_titles = "";
                            $sql = '
                                SELECT
                                    image_name,
                                    image_desc
                                FROM resume_image
                                WHERE list_id = "'.$sl['id'].'"
                            ';
                            $img_result = mysql_query($sql) or die(mysql_error());
                            while($img = mysql_fetch_array($img_result)) {
                                $pic_names .= str_replace(".png","",$img['image_name']) . "|";
                                $pic_titles .= $img['image_desc'] . "|";
                            }
                            echo '<a href="javascript:;" picture_names="'.substr($pic_names, 0, -1).'" picture_titles="'.substr($pic_titles, 0, -1).'"><li>'.$sl['list_title'].'</li></a>';
                        }
                        echo '      </ul>
                                </div>
                            </div>
                        ';
                    }
                }
            }
        ?>
        
        <div class="next-bar"><div class="next-arrow"></div></div>
        <div class="prev-bar"><div class="prev-arrow"></div></div>
        <div id="jump-menu">
                <ul>
                    <li class="selected" section="0"><span class="text">Top</span></li>
                    <!-- more items are added below dynamically based on sections -->
                </ul>
            </div>
    </body>
</html>
