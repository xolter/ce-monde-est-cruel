<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class OosalonPlayers
 * @package Hackathon\PlayerIA
 * @author Bryan Andriamasy
 */
class OosalonPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;

    public function getChoice()
    {
        $myLastChoice = $this->result->getLastChoiceFor($this->mySide);
        $myLastScore = $this->result->getLastScoreFor($this->mySide);
        if ($myLastScore === 0) {
            if ($myLastChoice === parent::rockChoice()) {
                return parent::scissorsChoice();
            }
            elseif ($myLastChoice === parent::paperChoice()) {
                return parent::rockChoice();
            }
            else
                return parent::paperChoice();
        }
        elseif ($myLastScore === 1) {
            return parent::paperChoice();
        }
        return parent::rockChoice();
    }
};
