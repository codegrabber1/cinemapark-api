<?php
namespace AXP\CinemaPark;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

/**
 * Class CinemaPark
 *
 * @author  Alexander Pushkarev <axp-dev@yandex.com>
 * @link    https://github.com/axp-dev/cinemapark-api
 * @package AXP\CinemaPark
 */
class CinemaPark
{
    /**
     * Список конечных url api
     *
     * @var array
     */
    private $endpoints = [
        'information' => 'http://json.integration.www.cinemapark.ru',
        'booking'     => 'http://api.booking.www.cinemapark.ru'
    ];

    /**
     * Получение списка мультиплексов и городов.
     *
     * @return array
     */
    public function getMultiplexes()
    {
        $url = $this->endpoints['information'] . '/multiplexes/';

        return $this->query($url);
    }

    /**
     * Получение списка фильмов.
     *
     * @return array
     */
    public function getFilms()
    {
        $url = $this->endpoints['information'] . '/films/';

        return $this->query($url);
    }

    /**
     * Привязка фильмов к мультиплексам.
     *
     * @return array
     */
    public function getFilmsMultiplexes()
    {
        $url = $this->endpoints['information'] . '/films_multiplexes/';

        return $this->query($url);
    }

    /**
     * Получение расписания фильма.
     *
     * @param int $id
     *
     * @return array
     */
    public function getRepertoir($id)
    {
        $url = $this->endpoints['information'] . '/repertoir/' . $id . '/';

        return $this->query($url);
    }

    /**
     * Получение расписания мультиплекса.
     *
     * @param int $id
     *
     * @return array
     */
    public function getMultiplexRepertoir($id)
    {
        $url = $this->endpoints['information'] . '/multiplex_repertoir/' . $id . '/';

        return $this->query($url);
    }

    /**
     * Получение дополнительной информации по фильму.
     *
     * @param int $id
     *
     * @return array
     */
    public function getFilmInfo($id)
    {
        $url = $this->endpoints['information'] . '/film_info/' . $id . '/';

        return $this->query($url);
    }

    /**
     * Получение списка залов по всем мультиплексам.
     *
     * @return array
     */
    public function getHalls()
    {
        $url = $this->endpoints['information'] . '/halls/';

        return $this->query($url);
    }

    /**
     * Получение списка форматов показа фильмов.
     *
     * @return array
     */
    public function getFormats()
    {
        $url = $this->endpoints['information'] . '/formats/';

        return $this->query($url);
    }

    /**
     * Комплексная выгрузка текущего расписания мультиплекса.
     *
     * @param int $id
     *
     * @return array
     */
    public function getTimeTable($id)
    {
        $url = $this->endpoints['information'] . '/timetable/' . $id . '/';

        return $this->query($url);
    }

    /**
     * Проверка возможности начать сессию выбора мест для бронирования или покупки мест
     *
     * @param int $multiplex_id
     * @param int $repertoir_id
     * @param int $mode
     *
     * @return array
     */
    public function checkBSession($multiplex_id, $repertoir_id, $mode)
    {
        $params = [
            'multiplex_id' => $multiplex_id,
            'repertoir_id' => $repertoir_id,
            'mode'         => $mode,
        ];
        $url = $this->endpoints['booking'] . '/check_b_session/?' . http_build_query($params);

        return $this->query($url, 'xml');
    }

    /**
     * Запрос к API
     *
     * @param string $url
     * @param string $responseType
     *
     * @return mixed
     * @throws CinemaParkException
     */
    protected function query($url, $responseType = 'json')
    {
        try {
            $client = new GuzzleClient();
            $response = $client->request('GET', $url);
            $result = [];

            switch ($responseType) {
                case 'xml':
                    $result = (array) simplexml_load_string($response->getBody());
                    break;
                case 'json':
                    $result = json_decode($response->getBody(), true);
                    break;
            }

            return $result;
        } catch (ClientException $e) {
            throw new CinemaParkException($e->getMessage());
        }
    }
}