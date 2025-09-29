<?php

namespace App\Test\Controller;

use App\Entity\Appros;
use App\Repository\ApprosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApprosControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ApprosRepository $repository;
    private string $path = '/appros/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Appros::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Appro index');

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
            'appro[quantite]' => 'Testing',
            'appro[prix]' => 'Testing',
            'appro[dateAppros]' => 'Testing',
            'appro[nomFornisseur]' => 'Testing',
            'appro[nomProduit]' => 'Testing',
        ]);

        self::assertResponseRedirects('/appros/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Appros();
        $fixture->setQuantite('My Title');
        $fixture->setPrix('My Title');
        $fixture->setDateAppros('My Title');
        $fixture->setNomFornisseur('My Title');
        $fixture->setNomProduit('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Appro');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Appros();
        $fixture->setQuantite('My Title');
        $fixture->setPrix('My Title');
        $fixture->setDateAppros('My Title');
        $fixture->setNomFornisseur('My Title');
        $fixture->setNomProduit('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'appro[quantite]' => 'Something New',
            'appro[prix]' => 'Something New',
            'appro[dateAppros]' => 'Something New',
            'appro[nomFornisseur]' => 'Something New',
            'appro[nomProduit]' => 'Something New',
        ]);

        self::assertResponseRedirects('/appros/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getQuantite());
        self::assertSame('Something New', $fixture[0]->getPrix());
        self::assertSame('Something New', $fixture[0]->getDateAppros());
        self::assertSame('Something New', $fixture[0]->getNomFornisseur());
        self::assertSame('Something New', $fixture[0]->getNomProduit());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Appros();
        $fixture->setQuantite('My Title');
        $fixture->setPrix('My Title');
        $fixture->setDateAppros('My Title');
        $fixture->setNomFornisseur('My Title');
        $fixture->setNomProduit('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/appros/');
    }
}
