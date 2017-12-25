<?php
namespace Home\Controller;
use Think\Controller;

class MovieController extends Controller {
    public function add()
    {
        $movie = array(
            'name' => I('name'),
            'cover' => I('cover'),
            'image' => I('image'),
            'introduction' => I('introduction'),
            'download' => I('download'),
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
}