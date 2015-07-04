<?php
class Migration_Create_v_log extends CI_Migration {

  public function up()
  {
    /**
     * v_log
     */
    $fields = array(
      'id_log'=>array('type'=>'BIGINT','constraint'=>20,'unsigned'=>TRUE,'auto_increment'=>TRUE),
      'message'=>array('type'=>'TEXT','null'=>TRUE),
      'scope'=>array('type'=>'VARCHAR','constraint'=>'32','null'=>FALSE,'default'=>'0'),
      'id_user'=>array('type'=>'BIGINT','constraint'=>20,'unsigned'=>TRUE,'null'=>TRUE),
      'created_at'=>array('type'=>'DATETIME','null'=>TRUE)
    );
    $this->dbforge->add_field($fields);
    $this->dbforge->add_key('id_log', TRUE);
    $this->dbforge->create_table('v_log');
  }

  public function down()
  {
    $this->dbforge->drop_table('v_log',TRUE);
  }

}

