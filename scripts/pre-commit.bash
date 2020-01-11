#!/usr/bin/env bash
NAME=$(git branch | grep '*' | sed 's/* //')

if [ $NAME != '(no branch)' ]
then

  composer check
  RETVAL=$?

  if [ $RETVAL -ne 0 ]
  then
    git stash pop -q
    echo "Cant commit with broken composer check, use git commit --no-verify instead if you want to commit without tests"
    exit 1
  fi

  git stash pop -q
fi

exit 0
