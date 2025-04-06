from abc import ABC, abstractmethod

class PaymentStrategy(ABC):
    @abstractmethod
    def pay(self, amount):
        pass

class PaymentStrategyContext:
    def __init__(self, strategy: PaymentStrategy):
        self._strategy = strategy

    def set_strategy(self, strategy: PaymentStrategy):
        self._strategy = strategy

    def checkout(self, amount):
        self._strategy.pay(amount)


class PaymentObserver(ABC):
    @abstractmethod
    def update(self, payment_info):
        pass

class CreditCardPayment(PaymentStrategy): #First concrete strategy
    def pay(self, amount):
        print(f'Paid using card - TK {amount}')

class BkashPayment(PaymentStrategy): #Second concrete strategy
    def pay(self, amount):
        print(f'Paid using bkash - TK {amount}')

class CashPayment(PaymentStrategy): #Third concrete strategy
    def pay(self, amount):
        print(f'Paid using cash - TK {amount}')


class EmailNotifier(PaymentObserver):
    def update(self, payment_info):
        print("Email sent to " + payment_info)

class OrderUpdate(PaymentObserver):
    def update(self, payment_info):
        print("Order status has been updated " + payment_info)

class InstructorNotify(PaymentObserver):
    def update(self, payment_info):
        print("New Order at " + payment_info)

class PaymentObserverContext:
    def __init__(self, strategy: PaymentStrategy, observers: list[PaymentObserver]):
        self._strategy = strategy
        self._observers = observers

    def add_observer(self, observer: PaymentObserver):
        self._observers.append(observer)

    def checkout(self, payment_info):
        for i in self._observers:
            i.update