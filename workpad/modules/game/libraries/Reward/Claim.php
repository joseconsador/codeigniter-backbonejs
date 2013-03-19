<?php

/**
 * This class represents a claimed reward item.
 */
class Reward_Claim extends Base
{
    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('reward_claim_model', '' ,true);

        return $CI->reward_claim_model;
    }

    // --------------------------------------------------------------------

    protected function validates()
    {
        if ($this->isNew()) {
            $user = new User($this->user_id);
            $reward = new Reward($this->reward_id);

            if ($user->points < $reward->points) {
                $this->_validation_errors['points'] = array('You don\'t have enough points.');

                return FALSE;
            }
        }

        return TRUE;
    }
}