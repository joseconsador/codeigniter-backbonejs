<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2013-03-15
 */

class Reward_claim_model extends MY_Model
{
    protected $_table = 'rewards_claim';
    protected $_primary = 'reward_claim_id';

    protected $_allowed_filters = array(
        'user_id','reward_id'
    );
}