<?php

namespace tests\models;

use app\models\User;
use app\repositories\TransferRepoInteface;
use app\repositories\UserRepoInteface;
use app\services\UserTransferBalanceService;

class UserTransferBalanceServiceTest extends \Codeception\Test\Unit
{
    public function testCalcBalanceService()
    {
        $userId = 1;
        $userBalance = 100000;
        $transferBalance = 50000;

        $userRepo =\Mockery::mock(UserRepoInteface::class);
        $transfersRepo = \Mockery::mock(TransferRepoInteface::class);

        $userModelMock = $this->getMockBuilder(User::class)
            ->setMethods(['save', 'attributes'])
            ->getMock();

        $userModelMock->method('attributes')->willReturn([
            'id',
            'balance',
        ]);

        $userModelMock->balance = $userBalance;
        $userModelMock->id = $userId;

        $userRepo->shouldReceive('findUserById')
            ->once()
            ->with($userId)
            ->andReturn($userModelMock);

        $transfersRepo->shouldReceive('findIncompleteOutcomingTransfersSum')
            ->once()
            ->with($userId)
            ->andReturn($transferBalance);
        $userTransferBalanceService = new UserTransferBalanceService($userRepo, $transfersRepo);
        $this->assertEquals($userTransferBalanceService->getUserTransferBalance($userId), 50000);
    }

    public function testCalcBalanceServiceDouble()
    {
        $userId = 1;
        $userBalance = 100000;
        $transferBalance = 50000;

        $userRepo =\Mockery::mock(UserRepoInteface::class);
        $transfersRepo = \Mockery::mock(TransferRepoInteface::class);

        $userModelMock = $this->getMockBuilder(User::class)
            ->setMethods(['save', 'attributes'])
            ->getMock();

        $userModelMock->method('attributes')->willReturn([
            'id',
            'balance',
        ]);

        $userModelMock->balance = $userBalance;
        $userModelMock->id = $userId;

        $userRepo->shouldReceive('findUserById')
            ->once()
            ->with($userId)
            ->andReturn($userModelMock);

        $transfersRepo->shouldReceive('findIncompleteOutcomingTransfersSum')
            ->once()
            ->with($userId)
            ->andReturn($transferBalance);
        $userTransferBalanceService = new UserTransferBalanceService($userRepo, $transfersRepo);
        $this->assertEquals($userTransferBalanceService->getDoubleUserTransferBalance($userId), 500.00);
    }
}
