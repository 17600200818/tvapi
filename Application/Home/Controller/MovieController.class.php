<?php
namespace Home\Controller;
use Think\Controller;

class MovieController extends Controller {
    public function add()
    {
        $isGood = 0;
        if (strstr(I('requestUrl'), 'dyzz')) {
            $isGood = 1;
        }

        $movie = array(
            'name' => I('name'),
            'cover' => I('cover'),
            'image' => I('image'),
            'introduction' => str_replace('&amp;middot;', '·', I('introduction')),
            'download' => I('download'),
            'realname' => trim(I('realname'), '　'),
            'year' => trim(I('year'), '　'),
            'place' => trim(I('place'), '　'),
            'category' => trim(I('category'), '　'),
            'language' => trim(I('language'), '　'),
            'subtitle' => trim(I('subtitle'), '　'),
            'file_format' => trim(I('file_format'), '　'),
            'video_size' => trim(I('video_size'), '　'),
            'film_length' => trim(I('film_length'), '　'),
            'director' => trim(str_replace('&amp;middot;', '·', str_replace('&lt;br /&gt;　　　　　', ',', I('director'))), '　'),
            'cast' => trim(str_replace('&amp;middot;', '·', str_replace('&lt;br /&gt;　　　　　', ',', I('cast'))), '　'),
            'is_good' => $isGood,
	    'douban_score' => trim(I('doubanScore'), '　'),
        );

        $result = D('Movies')->add($movie);
        if ($result) {
            echo 'ok';
        }else {
            echo 'error';
        }
    }

    public function getMovieInfo()
    {
        $ids = '';
        $i = '';

        $urls = D('dytts')->where('status = 0')->select();
        foreach ($urls as $movie) {
            $output = shell_exec("python /home/opt/dytt/getMovieInfo.py ".$movie['url']);
            $putputStr = substr($output, 0, -1);
            if ($putputStr == 'ok') {
                $ids .= $i.$movie['id'];
                $i = ',';
            }
        }

        if ($ids != '') {
            $result = M('dytts')->where("id in ($ids)")->save(['status'=> 1]);
            if ($result) {
                echo 'ok';
            }
        }
    }

    public function getThunder()
    {
        $i = 1;
        $url = 'https://tool.lu/urlconvert/ajax.html';

        $movies = D('Movies')->field('id, download')->where('`thunder` is null')->select();
        foreach ($movies as $movie) {
            $data = array('link' => $movie['download']);
            $response = $this->curlPost($url, $data);
            $thunder = $response['text']['thunder'];

            D('Movies')->where('id = '.$movie['id'])->save(['thunder'=> $thunder]);
            echo $movie['id'].'/////'.$i++."</br>";
        }
    }

    public function curlPost($url, $post_data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $output = curl_exec($ch);
        curl_close($ch);

        //打印获得的数据
        return json_decode($output, true);
    }
}
