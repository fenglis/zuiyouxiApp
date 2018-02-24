<?php

namespace app\controllers\api;

use app\models\api\Poll;
use app\models\api\PollOption;
use app\models\api\Support;
use PHPUnit\Framework\Exception;
use Yii;
use app\models\api\Comment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\components\Util;
use app\components\ErrorCode;
use app\components\BabelCrypt;
use app\models\api\Article;
use app\models\api\CommentPosition;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
{
    const COMMENT_INTVAL_TIME = 5;
    /**
     * 拉取文章评论
     */

    public function actionCommentlist()
    {
        try {
            $arrRequest = Util::getArrRequest();
            Util::responseJson();
            $type = Util::getParameter($arrRequest, 'type', 'string');
            $page = Util::getParameter($arrRequest, 'page', 'int', false);
            $page = empty ($page) ? 1 : $page;

            if ($type === 'article') { //拉取文章评论
                $tid = Util::getParameter($arrRequest, 'tid', 'int');  //文章id
                $list = $this->getCommentsOfArcticle($tid, $page, 'position');
                return [
                    'errid' => ErrorCode::OK,
                    'errmsg' => ErrorCode::$msgArr[ErrorCode::OK],
                    'content' => [
                        'arr' => $list
                    ],
                ];
            } elseif ($type === 'user') {
                $postid = util::getParameter($arrRequest, 'postid', 'int');
                $list = Comment::getCommentsOfComments($postid, $page);
                return [
                    'errid' => ErrorCode::OK,
                    'errmsg' => ErrorCode::$msgArr[ErrorCode::OK],
                    'content' => $list
                ];
            }
        } catch (Exception $e) {
            \Yii::error("actionCommentlist  is error msg = {$e->getMessage()}");
            return [
                'errid' => ErrorCode::HACKER_COME,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::HACKER_COME],
                'content' => ''
            ];
        }
    }


    public function getCommentsOfArcticle($tid, $page, $order = 'position')
    {
        if($order === 'hot') {
            $list = Comment::getHostsComment($tid, $page);
        } else {
            $list = Comment::getCommentsOfarticle($tid, $page, $order);
        }

        return $list;
    }

    public function actionPostcomment()
    {
        $arrRequest = Util::getArrRequest();
        Util::responseJson();
        try{
            $action = Util::getParameter ( $arrRequest, 'action', 'string' );
        }catch (Exception $e){
            \Yii::error("actionPostcomment {$e->getMessage()}");
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }

        if($action == 'reply') {
            try{

                $type = Util::getParameter ( $arrRequest, 'type', 'string' );
                $tid = Util::getParameter ( $arrRequest, 'tid', 'int' );
                $pname = Util::getParameter ( $arrRequest, 'pname', 'string' );
                $pid =  Util::getParameter ( $arrRequest, 'pid', 'string' );
                $recvUsername = Util::getParameter ( $arrRequest, 'receiveUsername', 'string',false);
                $recvUserid = Util::getParameter ( $arrRequest, 'receiveUserid', 'int',false);
                $project_id = Util::getParameter ( $arrRequest, 'project', 'int' );

                $cid = util::getParameter ( $arrRequest, 'postid', 'int', false );
                $msg = trim ( Util::getParameter ( $arrRequest, 'msg', 'string' ) );
                $pid = BabelCrypt::decryptNumber($pid);
                $voptid = 0;
            }catch (Exception $e){
                \Yii::error("actionPostcomment {$e->getMessage()}");
                return [
                    'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                    'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
                ];
            }
            return $this->addComment($action, $type, $tid, $pname, $pid, $recvUsername, $recvUserid, $msg, $voptid, $cid,$project_id);
        }elseif($action=='vote'){
            try{
                $tid = Util::getParameter ( $arrRequest, 'tid', 'int' );
                $pname = Util::getParameter ( $arrRequest, 'pname', 'string' );
                $pid =  Util::getParameter ( $arrRequest, 'pid', 'string' );
                $msg = trim ( Util::getParameter ( $arrRequest, 'msg', 'string',false ) );
                $voptid= Util::getParameter ( $arrRequest, 'vollid', 'int', false );
                $project_id = Util::getParameter ( $arrRequest, 'project', 'int' );
                $pid = BabelCrypt::decryptNumber($pid);
            }catch (Exception $e){
                return [
                    'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                    'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
                ];
            }
            return $this->addComment($action,  'article', $tid, $pname, $pid, "", 0, $msg, $voptid, 0,$project_id);
        }elseif($action == 'praise'){
            try{
                $tid = Util::getParameter ( $arrRequest, 'tid', 'int' );
                $pid =  Util::getParameter ( $arrRequest, 'pid', 'string' );
                //$username =  Util::getParameter ( $arrRequest, 'pname', 'string' );
                $pid = BabelCrypt::decryptNumber($pid);
            }catch (Exception $e){
                return [
                    'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                    'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
                ];
            }
            return $this->addComment($action,  'article', $tid, "", $pid, "", 0, "", 0, 0,0);
        }else{
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }
    }


    public function actioncommentaticle() {
        $arrRequest = Util::getArrRequest();
        Util::responseJson();
        try{
            $info['action'] = Util::getParameter ( $arrRequest, 'action', 'string' );
            $info['type'] = Util::getParameter ( $arrRequest, 'type', 'string' );
            $info['tid'] = Util::getParameter ( $arrRequest, 'tid', 'int' );
            $info['username'] = Util::getParameter ( $arrRequest, 'pname', 'string' );
            $info['userid'] =  Util::getParameter ( $arrRequest, 'pid', 'string' );
            $info['recv_username'] = Util::getParameter ( $arrRequest, 'receiveUsername', 'string',false);
            $info['recv_userid'] = Util::getParameter ( $arrRequest, 'receiveUserid', 'int',false);
            $info['project_id'] = Util::getParameter ( $arrRequest, 'project', 'string' );
            $info['id'] = util::getParameter ( $arrRequest, 'postid', 'int', false );
            $info['message'] = trim ( Util::getParameter ( $arrRequest, 'msg', 'string' ) );
            $info['userid'] = BabelCrypt::decryptNumber($info['userid']);

            return $this->addComment($info);

        }catch (Exception $e){
            \Yii::error("actionPostcomment {$e->getMessage()}");
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }
    }

    /**
     * @param $action   标识文章,投票,推荐评论
     * @param $type     标识父评论或子评论
     * @param $tid      文章/投票/推荐id
     * @param $pname    评论人
     * @param $pid      评论id
     * @param $receiveUsername  回复评论人,
     * @param $receiveUserid    回复评论人id
     * @param $msg              评论内容
     * @param $pollid           投票id
     * @param int $postId       评论id
     * @param int $project      项目id
     */
    public function addComment($action, $type, $tid, $pname, $pid, $receiveUsername, $receiveUserid, $msg, $voptid, $postId=0,$project=1)
    {
        $user_ip = Util::getClientIp();
        //请求类型是否合法
        if (!isset (\Yii::$app->params['comment_type'][$type])) {
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }
        // 对此条数据判断是否是父评论，还是子评论
        if ($type == 'article') {
            $fid = 0;
        } else{
            $fid = $postId;
        }
        $arrInsert = [
            'userid' => $pid,
            'fid' => $fid,
            'tid' => $tid,
            'username' => $pname!==null ? $pname : '',
            'message' => $msg,
            'userip' => $user_ip,
            'dateline' => time(),
            'special' => \Yii::$app->params['comment_type'][$type],  //区分父子评论
            'action' => \Yii::$app->params['comment_action'][$action],
            'recv_username' => $receiveUsername !== null ? $receiveUsername : '',
            'recv_userid' => $receiveUserid !== null ? $receiveUserid: 0,
            'project_id'=>$project,
        ];

        //判断评论的时间间隔
        $now = time();
        $comment = Comment::getComments(['tid'=>$tid, 'userid'=>$pid, 'action'=>$arrInsert['action']]);
        if (!empty($comment) && (($now - $comment[0]['dateline']) < self::COMMENT_INTVAL_TIME)) {
            return [
                'errid'=> ErrorCode::COMMENT_TIMES_TOO_FREQUENT,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::COMMENT_TIMES_TOO_FREQUENT],
            ];
        }

        switch ($action) {
            case 'reply':
                //评论文章
                $article = Article::getArticleById($tid);
                if(!empty($article)) {
                    $arrInsert['title'] = $article['title'];
                    $arrInsert['class_id'] = (int)$article['class_id'];
                }

                $newPostId = Comment::addComment($arrInsert);
                $newPostionId = CommentPosition::addCommentPosition($tid, $newPostId);
                Comment::updateCommentById($newPostId, ['position'=>$newPostionId]);   //没明白
                Article::increaseNum('comments', $tid);
                if($type == 'user') {   //用户回复评论
                    Comment::increaseNum('child_num',$postId);
                }
                break;
            case 'vote':
                //投票评论
                //判断是否投票
                if(!empty($comment)) {
                    return [
                        'errid'=> ErrorCode::COMMENTED,
                        'errmsg'=> ErrorCode::$msgArr[ErrorCode::COMMENTED],
                    ];
                }

                $poll = Poll::getPollById($tid);
                if(!empty($poll)) {
                    $arrInsert['title'] = $poll['content'];
                    $arrInsert['voptid'] = $voptid;
                    $arrInsert['class_id'] = \Yii::$app->params['comment_action']['vote'];
                }

                Comment::addComment($arrInsert);
                Poll::increaseNum('comments', $tid);
                PollOption::increasePolloption('votes', $voptid);  //票数加1
                break;

            case 'praise':
                $arrSelect = [
                    'tid'=>$tid,
                    'userid'=>$pid,
                ];
                $ret = Support::getSupportByTid($arrSelect);
                if(!empty($ret)) {
                    return [
                        'errid'=> ErrorCode::HACKER_COME,
                        'errmsg'=> '已经赞过',
                    ];
                }
                $arrSelect['dateline'] = time();
                Support::addUserSupport($arrSelect);
                Article::increaseNum('supports', $tid);
                break;
            default:
                return [
                    'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                    'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
                ];
        }

        return [
            'errid' => ErrorCode::OK,
            'errmsg' => ErrorCode::$msgArr[ErrorCode::OK],
        ];

    }
}
