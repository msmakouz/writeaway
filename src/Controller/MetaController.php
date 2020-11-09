<?php

declare(strict_types=1);

namespace Spiral\Keeper\Controller;

use Spiral\Http\Exception\ClientException\ServerErrorException;
use Spiral\Logger\Traits\LoggerTrait;
use Spiral\Router\Annotation\Route;
use Spiral\Translator\Traits\TranslatorTrait;
use Spiral\WriteAway\Database\Meta;
use Spiral\WriteAway\Repository\MetaRepository;
use Spiral\WriteAway\Request\MetaRequest;
use Spiral\WriteAway\Service\Pieces;

class MetaController
{
    use LoggerTrait;
    use TranslatorTrait;

    private Pieces $pieces;
    private MetaRepository $metaRepository;

    public function __construct(Pieces $pieces, MetaRepository $metaRepository)
    {
        $this->pieces = $pieces;
        $this->metaRepository = $metaRepository;
    }

    /**
     * @Route(name="writeAway:meta:save", group="writeAway", methods="POST", route="meta/save")
     * @param MetaRequest $request
     * @return array
     */
    public function save(MetaRequest $request): array
    {
        if (!$request->isValid()) {
            return [
                'status' => 400,
                'errors' => $request->getErrors(),
                'fields' => $request->getFields()
            ];
        }

        $meta = $this->metaRepository->findMeta($request->namespace, $request->view, $request->code);
        if (!$meta instanceof Meta) {
            return [
                'status' => 400,
                'error'  => $this->say('Unable to find requested meta.')
            ];
        }

        try {
            $this->pieces->saveMeta(
                $meta,
                (string)$request->title,
                (string)$request->description,
                (string)$request->keywords,
                (string)$request->html
            );
        } catch (\Throwable $exception) {
            $this->getLogger('default')->error('Meta update failed', compact('exception'));
            throw new ServerErrorException('Meta update failed', $exception);
        }

        return [
            'status' => 200,
            'id'     => $meta->id,
            'fields' => $request->getFields()
        ];
    }

    /**
     * @Route(name="writeAway:meta:get", group="writeAway", methods="GET", route="meta/get")
     * @param MetaRequest $request
     * @return array
     */
    public function get(MetaRequest $request): array
    {
        if (!$request->isValid()) {
            return [
                'status' => 400,
                'errors' => $request->getErrors(),
                'fields' => $request->getFields()
            ];
        }

        $meta = $this->metaRepository->findMeta($request->namespace, $request->view, $request->code);
        if (!$meta instanceof Meta) {
            return [
                'status' => 400,
                'error'  => $this->say('Unable to find requested meta.')
            ];
        }

        return [
            'status' => 200,
            'meta'   => $meta->pack()
        ];
    }
}
