<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class OosalonPlayers
 * @package Hackathon\PlayerIA
 * @author Bryan Andriamasy
 * @comment If i won I play the same, else I Counter pick, if draw then I choose paper, If it's tight I double counter
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
        $counterPick = $this->counterChoice($myLastChoice);
        $nbRound = $this->result->getNbRound();
        if ($myLastScore === 0) {
            return $counterPick;
        }
        elseif ($myLastScore === 1) {
            return parent::paperChoice();
        }
        if ($nbRound > 500 && $this->scoreIsTight()) {
            return $this->counterChoice($counterPick);
        }
        return $myLastChoice;
    }

    private function counterChoice($myLastChoice) {
        if ($myLastChoice === parent::rockChoice()) {
            return parent::scissorsChoice();
        }
        elseif ($myLastChoice === parent::paperChoice()) {
            return parent::rockChoice();
        }
        return parent::paperChoice();
    }

    private function scoreIsTight() {
        $myStat= $this->result->getStatsFor($this->mySide);
        $oppoStat= $this->result->getStatsFor($this->opponentSide);
        $diff = $myStat['score'] - $oppoStat['score'];
        if ($diff < 0) {
            $diff = $diff * -1;
        }
        return $diff < 20;
    }
};
