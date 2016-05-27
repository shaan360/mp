<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\components\MiscHelpers;
use frontend\models\Meeting;
use frontend\models\MeetingNote;
use frontend\models\MeetingPlace;
use frontend\models\MeetingTime;
/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */
?>
<tr>
  <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
    <center>
      <table cellspacing="0" cellpadding="0" width="600" class="w320">
        <tr>
          <td class="header-lg">
            Your Meeting Request
          </td>
        </tr>
        <tr>
          <td class="free-text">
            <p><em>Hi, <?php echo $owner; ?> is inviting you to an event using a new service called <?php echo HTML::a(Yii::t('frontend','Meeting Planner'),MiscHelpers::buildCommand($meeting_id,Meeting::COMMAND_HOME,0,$user_id,$auth_key)); ?>. The service makes it easy to plan meetings without the exhausting threads of repetitive emails. Please try it out below.</em></p>
            <p><?php echo $intro; ?></p>
          </td>
        </tr>
        <tr>
          <td class="button">
            <div><!--[if mso]>
              <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://" style="height:45px;v-text-anchor:middle;width:155px;" arcsize="15%" strokecolor="#ffffff" fillcolor="#ff6f6f">
                <w:anchorlock/>
                <center style="color:#ffffff;font-family:Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;">Track Order</center>
              </v:roundrect>
            <![endif]--><a href=<?php echo $links['view']; ?>
            style="background-color:#ff6f6f;border-radius:5px;color:#ffffff;display:inline-block;font-family:'Cabin', Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;">View Meeting Request</a></div>
          </td>
        </tr>
        <tr>
          <td class="free-text">
            <?php
                if (!$noPlaces) {
                    echo HTML::a(Yii::t('frontend','Accept all places and times'),$links['acceptall']);
                    ?><br /><?php
                }
             ?>
               <?php
               if ($meetingSettings->participant_finalize && count($places)==1 && count($times)==1) { ?>
                 <?php echo HTML::a(Yii::t('frontend','Finalize meeting'),$links['finalize']); ?>
                <br />
               <?php
               }
               ?>
            <?php echo HTML::a(Yii::t('frontend','decline the meeting'),$links['decline']); ?>
            <br />
          </td>
        </tr>
        <tr>
          <td class="w320">
            <table cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td class="mini-container-left">
                  <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td class="mini-block-padding">
                        <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                          <tr>
                            <td class="mini-block">
                              <span class="header-sm">Possible Times</span><br />
                              <?php echo HTML::a(Yii::t('frontend','accept all times'),$links['accepttimes']); ?><br />
                              <?php
                              if ($meetingSettings->participant_add_date_time) { ?>
                              <?php echo HTML::a(Yii::t('frontend','suggest a time'),$links['addtime']); ?><br />
                              <?php
                              }
                              ?>
                              <?php
                                foreach($times as $t) {
                                  ?>
                                      <?php echo Meeting::friendlyDateFromTimestamp($t->start); ?><br />
                                      <?php
                                    }
                                ?>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
                <td class="mini-container-right">
                  <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td class="mini-block-padding">
                        <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                          <tr>
                            <td class="mini-block">
                              <span class="header-sm">Possible Places</span><br />
                              <?php
                              if (!$noPlaces) {
                              ?>
                              <?php echo HTML::a(Yii::t('frontend','accept all places'),$links['acceptplaces']); ?><br />
                              <?php
                              if ($meetingSettings->participant_add_place) { ?>
                              <?php echo HTML::a(Yii::t('frontend','suggest a place'),$links['addplace']); ?><br />
                              <?php
                              }
                              ?>
                              <?php
                                foreach($places as $p) {
                                  ?>
                                      <?php echo $p->place->name; ?><br/ >
                                      <span style="font-size:75%;"><?php echo $p->place->vicinity; ?> <?php echo HTML::a(Yii::t('frontend','view map'),
                                      MiscHelpers::buildCommand($meeting_id,Meeting::COMMAND_VIEW_MAP,$p->id,$user_id,$auth_key)); ?></span><br />
                                <?php
                                    }
                                ?>
                                <?php
                              } else {
                                  ?>
                                  Phone or video <br />
                              <?php
                                }
                              ?>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <?php echo \Yii::$app->view->renderFile('@common/mail/section-notes.php',['notes'=>$notes,'links'=>$links]) ?>
      </table>
    </center>
  </td>
</tr>
<?php echo \Yii::$app->view->renderFile('@common/mail/footer_dynamic.php',['links'=>$links]) ?>
