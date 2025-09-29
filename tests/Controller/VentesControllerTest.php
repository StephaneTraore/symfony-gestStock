<?php

namespace App\Test\Controller;

use App\Entity\Ventes;
use App\Repository\VentesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VentesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private VentesRepository $repository;
    private string $path = '/ventes/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Ventes::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Vente index');

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
            'vente[quantite]' => 'Testing',
            'vente[prix]' => 'Testing',
            'vente[dateVente]' => 'Testing',
            'vente[nomProduit]' => 'Testing',
            'vente[nomClient]' => 'Testing',
        ]);

        self::assertResponseRedirects('/ventes/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ventes();
        $fixture->setQuantite('My Title');
        $fixture->setPrix('My Title');
        $fixture->setDateVente('My Title');
        $fixture->setNomProduit('My Title');
        $fixture->setNomClient('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Vente');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ventes();
        $fixture->setQuantite('My Title');
        $fixture->setPrix('My Title');
        $fixture->setDateVente('My Title');
        $fixture->setNomProduit('My Title');
        $fixture->setNomClient('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'vente[quantite]' => 'Something New',
            'vente[prix]' => 'Something New',
            'vente[dateVente]' => 'Something New',
            'vente[nomProduit]' => 'Something New',
            'vente[nomClient]' => 'Something New',
        ]);

        self::assertResponseRedirects('/ventes/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getQuantite());
        self::assertSame('Something New', $fixture[0]->getPrix());
        self::assertSame('Something New', $fixture[0]->getDateVente());
        self::assertSame('Something New', $fixture[0]->getNomProduit());
        self::assertSame('Something New', $fixture[0]->getNomClient());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Ventes();
        $fixture->setQuantite('My Title');
        $fixture->setPrix('My Title');
        $fixture->setDateVente('My Title');
        $fixture->setNomProduit('My Title');
        $fixture->setNomClient('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/ventes/');
    }
}
