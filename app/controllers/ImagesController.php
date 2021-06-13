<?php

class ImagesController extends \ApiController
{

    /**
     * Show sport image
     *
     * @param $sportId
     * @return mixed
     */
    public function getSportImage($sportId)
    {
        $sport = Sport::find($sportId);

        $path = $this->getSportsImagePath($sport);

        $response = Response::make(file_get_contents($path), '200');

        $response->header('Content-Type', $sport->mime);

        return $response;
    }

    /**
     * Get sport's image path
     *
     * @param $sport
     * @return string
     */
    private function getSportsImagePath($sport)
    {
        $path = ($sport->image == 'default.png') ? 'images/default.png' : "images/{$sport->user_id}/{$sport->image}";

        return storage_path($path);
    }

    /**
     * Show player image
     *
     * @param $playerId
     * @return \Illuminate\Http\Response
     */
    public function getPlayerImage($playerId)
    {
        $player = Player::find($playerId);

        $path = $this->getPlayersImagePath($player);

        $response = Response::make(file_get_contents($path), '200');

        $response->header('Content-Type', $player->mime);

        return $response;
    }

    /**
     * Get player's image path
     *
     * @param $player
     * @return string
     */
    private function getPlayersImagePath($player)
    {
        $path = ($player->image == 'default.png') ? 'players/default.png' : "players/{$player->id}/{$player->image}";

        return storage_path($path);
    }
}
