<?php

namespace App\Test\Controller;

use App\Entity\Stocks;
use App\Repository\StocksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StocksControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private StocksRepository $repository;
    private string $path = '/stocks/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Stocks::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Stock index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'stock[quantite]' => 'Testing',
            'stock[prixUnitaire]' => 'Testing',
            'stock[dateReception]' => 'Testing',
            'stock[nomProduit]' => 'Testing',
            'stock[nomFournisseur]' => 'Testing',
        ]);

        self::assertResponseRedirects('/stocks/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Stocks();
        $fixture->setQuantite('My Title');
        $fixture->setPrixUnitaire('My Title');
        $fixture->setDateReception('My Title');
        $fixture->setNomProduit('My Title');
        $fixture->setNomFournisseur('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Stock');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Stocks();
        $fixture->setQuantite('My Title');
        $fixture->setPrixUnitaire('My Title');
        $fixture->setDateReception('My Title');
        $fixture->setNomProduit('My Title');
        $fixture->setNomFournisseur('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'stock[quantite]' => 'Something New',
            'stock[prixUnitaire]' => 'Something New',
            'stock[dateReception]' => 'Something New',
            'stock[nomProduit]' => 'Something New',
            'stock[nomFournisseur]' => 'Something New',
        ]);

        self::assertResponseRedirects('/stocks/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getQuantite());
        self::assertSame('Something New', $fixture[0]->getPrixUnitaire());
        self::assertSame('Something New', $fixture[0]->getDateReception());
        self::assertSame('Something New', $fixture[0]->getNomProduit());
        self::assertSame('Something New', $fixture[0]->getNomFournisseur());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Stocks();
        $fixture->setQuantite('My Title');
        $fixture->setPrixUnitaire('My Title');
        $fixture->setDateReception('My Title');
        $fixture->setNomProduit('My Title');
        $fixture->setNomFournisseur('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/stocks/');
    }
}
