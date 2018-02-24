<?php

namespace app\controllers\api;

use app\components\Util;
use app\components\ErrorCode;
use app\components\BabelCrypt;
use app\models\api\BattleRecommend;
use app\models\api\Comment;
use app\models\api\UserFavArticle;
use app\models\api\UserFeedback;
use PHPUnit\Framework\Exception;
use Yii;
use app\models\api\Article;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\api\ArticleClass;
use app\models\api\Poll;
use app\models\api\PollOption;

/**
 * ArticlesController implements the CRUD actions for Articles model.
 */
class ArticleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionArticlelist()
    {
        $arrRequest = Util::getArrRequest();
        $article_count = Util::getParameter ( $arrRequest, 'article_count', 'int', false );
        $id = Util::getParameter ( $arrRequest, 'id', 'int',false);
        $type = Util::getParameter ( $arrRequest, 'type', 'string', false );
        $project = Util::getParameter ( $arrRequest, 'project', 'int', false );
        $action = Util::getParameter ( $arrRequest, 'action', 'string', false );
        $platform = Util::getParameter ( $arrRequest, 'platform', 'int', false );
        Util::responseJson();

        $list = Article::getAticlelist($id,$article_count,$type,$project,$platform,$action);
        if (!empty($list)) {
            foreach($list as $key => $value) {
                $list[$key]['created'] = date('Y-m-d', $value['created']);
                $list[$key]['img'] = \Yii::$app->params['attachUrl'] . \Yii::$app->params['articleImage'] . '/' . $value['img'];
            }

            $classes = ArticleClass::getClassList($project);

            return [
                'errid' => ErrorCode::OK,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::OK],
                'content' => ['arr'=>$list],
                'type' => $classes
            ];
        } else {
            return [
                'errid' => ErrorCode::FAIL,
                'errmsg' => '',
                'content' => '',
                'type' => ''
            ];
        }
    }



    public function actionArticleread()
    {
        $this->layout = false;
        try {
            $arrRequest = Util::getArrRequest();
            $id = Util::getParameter($arrRequest, 'id', 'int');
            if($id <= 0) {
                throw new Exception("tid do not exists: {$id}");
            }
            $info = Article::getArticleByIdAddBrowses($id);
            if(!empty($info)){ //如果文章存在
                $info['created'] = date('Y-m-d', $info['created']);
                return $this->render('articleread',['article'=>$info]);

            }else{//如果不存在
                throw new Exception("not exists article id: {$id}");
            }

        } catch (Exception $e) {
            Yii::warning($e->getMessage());
            Util::responseJson();
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }
    }

    /**
     * 获取文章评论和点赞数
     * @return array|string
     */
    public function actionArticleitemread()
    {
        try {
            $arrRequest = Util::getArrRequest();
            Util::responseJson();
            $id = Util::getParameter($arrRequest, 'tid', 'int');
            if($id <= 0) {
                throw new Exception("tid do not exists: {$id}");
            }
            $info = Article::getNumById($id, ["id as tid", "comments", "supports"]);
            if(!empty($info)){ //如果文章存在
                return [
                    'errid' => ErrorCode::OK,
                    'errmsg' => ErrorCode::$msgArr[ErrorCode::OK],
                    'content' => $info,
                ];
            }else{//如果不存在
                throw new Exception("not exists article id: {$id}");
            }

        } catch (Exception $e) {
            Yii::warning($e->getMessage());
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }
    }


    /**
     * 获取投票
     * @return array
     */
    public function actionPollread()
    {
        try {
            $arrRequest = Util::getArrRequest();
            Util::responseJson();
            $pid =  Util::getParameter($arrRequest, 'pid', 'string', false);
            $page = Util::getParameter($arrRequest, 'page', 'int', false);
            $project_id = Util::getParameter ($arrRequest, 'project', 'int', false);
            $page = $page?$page:1;

            if(!empty($pid)) {
                $pid = BabelCrypt::decryptNumber($pid);
            }

        } catch (Exception $e) {
            Yii::warning($e->getMessage());
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }

        $page = max(1,$page);
        //$action 为1则表示为投票评论
        $info = $this->getPoll($pid,$page,$project_id, 1);
        return [
            'errid' => ErrorCode::OK,
            'errmsg' => ErrorCode::$msgArr[ErrorCode::OK],
            'content' => [
                'arr' => $info['poll'],
                'hot' => $info['hots'],
                'new' => $info['news'],
            ]
        ];


    }

    public function getPoll($pid,$page,$project_id, $action)
    {
        $ret = ["poll" => [], "hots" => [], "news" => []];
        $poll = Poll::getPoll($project_id);
        if (!empty($poll)) {
            $poll['img'] = \Yii::$app->params['attachUrl'] . \Yii::$app->params['pollImage'] . '/' . $poll['img'];
            $poll['polloption'] = PollOption::getPollOptionByPollid($poll['pollid']);
            if (!empty($pid)) {
                //检查是否已经评论
                $comment = Comment::getCommentByUserId($pid, $poll['pollid'], $action);
                $poll['_is_poll'] = empty($comment) ? 0 : 1;
            } else {
                $poll['_is_poll'] = 0;
            }

            $hots = Comment::getCommentsOfArticle($poll['pollid'], $page, 'hot', $action);
            $news = Comment::getCommentsOfArticle($poll['pollid'], $page, 'new', $action);

            return [
                'poll'=>$poll,
                'hots'=>$hots,
                'news'=>$news
            ];

        }
        return $ret;
    }

    /**
     * 获取推荐阵容 评论点赞
     */
    public function actionRecbatitemsread()
    {
        try {
            $arrRequest = Util::getArrRequest();
            Util::responseJson();
            $project_id = Util::getParameter ($arrRequest, 'project', 'int');
            $recbat = BattleRecommend::getOneRecbat($project_id);
            return [
                'errid' => ErrorCode::OK,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::OK],
                'recbat' => $recbat,
            ];
        } catch (Exception $e) {
            Yii::warning($e->getMessage());
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }

        return [
            'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
            'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
        ];
    }



    /**
     * 获取推荐阵容 返回html页面
     */
    public function actionRecbatread()
    {
        try {
            $this->layout = false;
            $arrRequest = Util::getArrRequest();
            $project_id = Util::getParameter ($arrRequest, 'project', 'int');
            $recbat = BattleRecommend::getOneRecbat($project_id);
            if (!empty($recbat)) {
                $generals = explode(',', $recbat [ 'generals' ]);
                $screenshot = explode(',', $recbat [ 'screenshot' ]);

                return $this->render('recbatread',['recbat'=>$recbat, 'generals'=>$generals, 'screenshot'=>$screenshot]);
            }
        } catch (Exception $e) {
            Util::responseJson();
            Yii::warning($e->getMessage());
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }
    }

    //用户收藏 post
    public function actionModuserfav()
    {
        Util::responseJson();
        $arrRequest = Util::getArrRequest();
        try {
            $tid = Util::getParameter ( $arrRequest, 'tid', 'int' );
            $pid = Util::getParameter ( $arrRequest, 'pid', 'string' );
            $action = Util::getParameter ( $arrRequest, 'action', 'string' );
            $pid = BabelCrypt::decryptNumber($pid);

        } catch (Exception $e) {
            Yii::warning($e->getMessage());
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }

        return self::userFavorite($pid, $tid, $action);
    }

    public static function userFavorite($userid, $tid, $action)
    {
        if (!in_array($action, array('add', 'cancel'))) {
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }
        $fav = UserFavArticle::getFavoriteByTid($userid, $tid);
        if ($action === 'add') { //添加收藏
            if (!empty($fav)) {
                if ((int)$fav['status'] === 1) { //用户已收藏
                    return [
                        'errid'=> ErrorCode::FAVORITEED,
                        'errmsg'=> ErrorCode::$msgArr[ErrorCode::FAVORITEED],
                    ];
                } else {
                    //重新收藏，修改status=1
                    $arrUpdate = [
                        'status' => 1
                    ];
                    UserFavArticle::editUserFavorite($fav['id'], $arrUpdate);
                }
            } else {
                $arrInsert = [
                    'userid' => $userid,
                    'tid' => $tid,
                    'status' => 1,
                    'created' => time()
                ];
                UserFavArticle::insertUserFavArticle($arrInsert);
            }

            return [
                'errid' => ErrorCode::OK,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::OK],
            ];
        } else {
            //取消收藏
            if(!empty($fav) && (int)$fav['status'] === 1) {
                $arrUpdate = [
                    'status' => 0
                ];

                UserFavArticle::editUserFavorite($fav['id'], $arrUpdate);
                return [
                    'errid' => ErrorCode::CANCEL_FAVORIT,
                    'errmsg' => ErrorCode::$msgArr[ErrorCode::CANCEL_FAVORIT],
                ];
            } else {
                return [
                    'errid' => ErrorCode::UNFAVORITEED,
                    'errmsg' => ErrorCode::$msgArr[ErrorCode::UNFAVORITEED],
                ];
            }

        }
    }

    /**
     * 用户反馈 post请求
     */
    public function actionFeedback()
    {
        try {
            Util::responseJson();
            $arrRequest = Util::getArrRequest();
            $message = Util::getParameter($arrRequest, 'message', 'string');
            $username = Util::getParameter($arrRequest, 'username', 'string');
            $pid = Util::getParameter($arrRequest, 'pid', 'string');
            $pid = BabelCrypt::decryptNumber($pid);
            $arrInsert = [
                'content' => $message,
                'userid' => $pid,
                'username' => $username
            ];

            UserFeedback::addFeedback($arrInsert);
        } catch (Exception $e) {
            Yii::warning($e->getMessage());
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



    public function actionGetuserfavarticlelist()
    {
        try{
            Util::responseJson();
            $arrRequest = Util::getArrRequest();
            $pid =  Util::getParameter ( $arrRequest, 'pid', 'string' ) ;
            $page = Util::getParameter ( $arrRequest, 'page', 'int',false );
            $pid = BabelCrypt::decryptNumber($pid);
        }catch (Exception $e){
            Logger::warning("param error:%s",$e->getMessage());
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }
        $page = max(1,$page);
        $list = UserFavArticle::getUserFavorites($pid,$page);
        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $list [$key] ['created'] = date('Y-m-d', $value ['created']);
                $list [$key] ['img'] = \Yii::$app->params['attachUrl'] . \Yii::$app->params['articleImage'] . '/' . $value['img'];
            }
        }
        return [
            'errid' => ErrorCode::OK,
            'errmsg' => ErrorCode::$msgArr[ErrorCode::OK],
            'content' => [
                'arr' => $list
            ],
        ];
    }


}
